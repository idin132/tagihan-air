<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pengelola;
use App\Models\PembayaranAir;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranAirController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);

        $pembayarans = PembayaranAir::with(['pelanggan', 'pengelola'])
            ->latest()
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        $pelanggans = Pelanggan::all();
        $pengelolas = Pengelola::all();

        return view('pembayaran.index', compact('pembayarans', 'pelanggans', 'pengelolas'));
    }

    public function store(Request $request)
    {
        // SEBELUMNYA: kamu menghitung total_tagihan di sini
        // $total_tagihan = ($request->akhir - $request->awal) * 5000;

        // SEKARANG: Langsung simpan saja, biarkan TRIGGER yang menghitung
        PembayaranAir::create([
            'bulan' => $request->bulan,
            'no_pelanggan' => $request->no_pelanggan,
            'stand_meter_awal' => $request->stand_meter_awal,
            'stand_meter_akhir' => $request->stand_meter_akhir,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'no_pengelola' => auth()->id(),
            // stand_meter_total dan total_tagihan TIDAK USAH dimasukkan, 
            // karena akan diisi otomatis oleh database
        ]);

        return response()->json(['success' => true, 'message' => 'Data tersimpan!']);
    }

    public function edit($id)
    {
        // Gunakan 'with' agar data pelanggan dan pengelola ikut terkirim ke JS
        $pembayaran = PembayaranAir::with(['pelanggan', 'pengelola'])->findOrFail($id);
        return response()->json($pembayaran);
    }

    public function update(Request $request, $id)
    {
        $pembayaran = PembayaranAir::findOrFail($id);

        $total_pakai = $request->stand_meter_akhir - $request->stand_meter_awal;
        $total_tagihan = ($total_pakai * 3500) + 20000;

        $pembayaran->update([
            'bulan' => $request->bulan,
            'no_pelanggan' => $request->no_pelanggan,
            'stand_meter_awal' => $request->stand_meter_awal,
            'stand_meter_akhir' => $request->stand_meter_akhir,
            'stand_meter_total' => $total_pakai,
            'total_tagihan' => $total_tagihan,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'no_pengelola' => $request->no_pengelola,
        ]);

        return response()->json(['success' => true, 'message' => 'Tagihan berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        PembayaranAir::destroy($id);
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
    }

    // public function cetakLaporan(Request $request)
    // {
    //     // SEBELUMNYA: PembayaranAir::with('pelanggan')->where...->get();

    //     // SEKARANG: Panggil dari View (Tabel Virtual)
    //     $pembayarans = DB::table('view_laporan_lengkap')
    //         ->whereBetween('tanggal_pembayaran', [$request->awal, $request->akhir])
    //         ->get();

    //     $pdf = Pdf::loadView('pembayaran.laporan_pdf', compact('pembayarans'));
    //     return $pdf->stream();
    // }

    public function cetakLaporan(Request $request)
    {
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
        ]);

        $awal = $request->tgl_awal;
        $akhir = $request->tgl_akhir;

        // Ambil data berdasarkan rentang tanggal pembayaran
        $data = PembayaranAir::with(['pelanggan', 'pengelola'])
            ->whereBetween('tanggal_pembayaran', [$awal, $akhir])
            ->orderBy('tanggal_pembayaran', 'asc')
            ->get();

        $totalPendapatan = $data->sum('total_tagihan');

        // Load view khusus untuk PDF
        $pdf = Pdf::loadView('pembayaran.laporan_pdf', [
            'pembayarans' => $data,
            'tgl_awal' => $awal,
            'tgl_akhir' => $akhir,
            'total' => $totalPendapatan
        ]);

        // Download atau stream ke browser
        return $pdf->stream('Laporan_Tagihan_' . $awal . '_ke_' . $akhir . '.pdf');
    }

    public function rekapBulanan(Request $request)
    {
        $bulan = $request->get('bulan', date('F')); // Default bulan sekarang

        // Memanggil Stored Procedure
        // DB::select selalu mengembalikan array of objects
        $rekap = DB::select('CALL rekap_pendapatan_bulan(?)', [$bulan]);

        // Karena procedure rekap_pendapatan_bulan cuma mengembalikan 1 baris, kita ambil index ke-0
        $dataRekap = $rekap[0] ?? null;

        return view('pembayaran.rekap', compact('dataRekap', 'bulan'));
    }
}