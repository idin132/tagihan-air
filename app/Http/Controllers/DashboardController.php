<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\PembayaranAir;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Ringkasan (Fungsi Agregat)
        $totalPelanggan = Pelanggan::count();
        
        // Menghitung total transaksi bulan ini
        $transaksiBulanIni = PembayaranAir::whereMonth('tanggal_pembayaran', Carbon::now()->month)
                            ->whereYear('tanggal_pembayaran', Carbon::now()->year)
                            ->count();

        // Menghitung total pendapatan bulan ini (SUM)
        $totalPendapatan = PembayaranAir::whereMonth('tanggal_pembayaran', Carbon::now()->month)
                            ->whereYear('tanggal_pembayaran', Carbon::now()->year)
                            ->sum('total_tagihan');

        // 2. Data Tabel Pembayaran Terbaru (Ambil 5 data terakhir)
        $pembayaranTerbaru = PembayaranAir::with('pelanggan')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('dashboard', compact(
            'totalPelanggan', 
            'transaksiBulanIni', 
            'totalPendapatan', 
            'pembayaranTerbaru'
        ));
    }
}