<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pengelola;
use App\Models\PembayaranAir;
use Illuminate\Http\Request;

class PembayaranAirController extends Controller
{
    // Menampilkan riwayat pembayaran
    public function index()
    {
        $pembayarans = PembayaranAir::with(['pelanggan', 'pengelola'])->latest()->get();
        return view('pembayaran.index', compact('pembayarans'));
    }

    // Menampilkan form input tagihan
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $pengelolas = Pengelola::all(); // Untuk memilih siapa petugasnya
        return view('pembayaran.create', compact('pelanggans', 'pengelolas'));
    }

    // Menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'no_pelanggan' => 'required',
            'bulan' => 'required',
            'stand_meter_awal' => 'required|numeric',
            'stand_meter_akhir' => 'required|numeric|gt:stand_meter_awal',
            'no_pengelola' => 'required',
        ]);

        // Logika Perhitungan di Server (Agar Aman)
        $totalPakai = $request->stand_meter_akhir - $request->stand_meter_awal;
        $hargaPerMeter = 5000;
        $totalTagihan = $totalPakai * $hargaPerMeter;

        PembayaranAir::create([
            'bulan' => $request->bulan,
            'no_pelanggan' => $request->no_pelanggan,
            'stand_meter_awal' => $request->stand_meter_awal,
            'stand_meter_akhir' => $request->stand_meter_akhir,
            'stand_meter_total' => $totalPakai,
            'total_tagihan' => $totalTagihan,
            'tanggal_pembayaran' => $request->tanggal_pembayaran ?? now(),
            'no_pengelola' => $request->no_pengelola,
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Tagihan berhasil disimpan!');
    }
}