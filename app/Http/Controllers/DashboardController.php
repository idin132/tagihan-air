<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\PembayaranAir;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     // 1. Statistik Ringkasan (Fungsi Agregat)
    //     $totalPelanggan = Pelanggan::count();

    //     // Menghitung total transaksi bulan ini
    //     $transaksiBulanIni = PembayaranAir::whereMonth('tanggal_pembayaran', Carbon::now()->month)
    //                         ->whereYear('tanggal_pembayaran', Carbon::now()->year)
    //                         ->count();

    //     // Menghitung total pendapatan bulan ini (SUM)
    //     $totalPendapatan = PembayaranAir::whereMonth('tanggal_pembayaran', Carbon::now()->month)
    //                         ->whereYear('tanggal_pembayaran', Carbon::now()->year)
    //                         ->sum('total_tagihan');

    //     // 2. Data Tabel Pembayaran Terbaru (Ambil 5 data terakhir)
    //     $pembayaranTerbaru = PembayaranAir::with('pelanggan')
    //                         ->latest()
    //                         ->take(5)
    //                         ->get();

    //     return view('dashboard', compact(
    //         'totalPelanggan', 
    //         'transaksiBulanIni', 
    //         'totalPendapatan', 
    //         'pembayaranTerbaru'
    //     ));
    // }

    public function index()
    {
        $totalPelanggan = Pelanggan::count();
        $transaksiBulanIni = PembayaranAir::whereMonth('tanggal_pembayaran', Carbon::now()->month)->whereYear('tanggal_pembayaran', Carbon::now()->year)->count();
        $pembayaranTerbaru = PembayaranAir::with('pelanggan')
            ->latest()
            ->take(5)
            ->get();
        // Fungsi Agregat: SUM dan COUNT
        $bulanSekarang = date('Y-m'); // hasil: 2026-01
        $rekap = DB::select("CALL rekap_bulanan(?)", [$bulanSekarang]);

        // $totalPendapatan = DB::table('pembayaran_air')->sum('total_tagihan');
        $totalPendapatan = $rekap[0]->total_duit ?? 0;
        $jumlahTransaksi = DB::table('pembayaran_air')->count();

        // Fungsi String & Date (Contoh: Mengambil inisial nama pengelola)
        $pengelola = DB::table('pengelola')
            ->selectRaw("UPPER(LEFT(nama_pengelola, 1)) as inisial")
            ->get();

        return view('dashboard', compact('totalPendapatan', 'jumlahTransaksi', 'totalPelanggan', 'transaksiBulanIni', 'pengelola', 'pembayaranTerbaru'));
    }
}