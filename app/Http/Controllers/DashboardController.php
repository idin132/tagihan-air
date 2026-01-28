<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\PembayaranAir;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $totalPelanggan = Pelanggan::count();
        $transaksiBulanIni = PembayaranAir::whereMonth('tanggal_pembayaran', Carbon::now()->month)->whereYear('tanggal_pembayaran', Carbon::now()->year)->count();
        
        // Data Pembayaran Terbaru menggunakan VIEW
        $pembayaranTerbaru = DB::table('view_dashboard_pembayaran')->latest()
            ->orderBy('tanggal_pembayaran')
            ->limit(5)
            ->get();
        
        // Fungsi Agregat: SUM dan COUNT dan PROCEDURE
        $bulanSekarang = date('Y-m'); // hasil: 2026-01
        $rekap = DB::select("CALL rekap_bulanan(?)", [$bulanSekarang]);
        $totalPendapatan = $rekap[0]->total_duit ?? 0;

        // Memanggil Stored Function dari database
        $query = DB::select("SELECT hitung_saldo_utama() AS saldo");
        $saldoUtama = $query[0]->saldo;
        $totalPengeluaran = DB::table('pengeluaran')->sum('biaya_pengeluaran');

        $totalSeluruhPendapatan = DB::table('pembayaran_air')->sum('total_tagihan');
        $jumlahTransaksi = DB::table('pembayaran_air')->count();

        // Fungsi String & Date (Contoh: Mengambil inisial nama pengelola)
        $pengelola = DB::table('pengelola')
            ->selectRaw("UPPER(LEFT(nama_pengelola, 1)) as inisial")
            ->get();

        return view('dashboard', compact(
            'totalPendapatan',
            'jumlahTransaksi',
            'totalPelanggan',
            'transaksiBulanIni',
            'pengelola',
            'pembayaranTerbaru',
            'totalSeluruhPendapatan',
            'saldoUtama',
            'totalPengeluaran'
        ));
    }
}