<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\PembayaranAir;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = Pelanggan::count();
        $totalTagihanBulanIni = PembayaranAir::where('bulan', date('F Y'))->sum('total_tagihan');
        $transaksiTerbaru = PembayaranAir::with('pelanggan')->latest()->take(5)->get();

        return view('dashboard', compact('totalPelanggan', 'totalTagihanBulanIni', 'transaksiTerbaru'));
    }
}