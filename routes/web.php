<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengelolaController;
use App\Http\Controllers\PembayaranAirController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');


Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/dashboard', DashboardController::class);

    // Manajemen Data (Resource)
    Route::resource('/pelanggan', PelangganController::class);
    Route::resource('/pengelola', PengelolaController::class);
    Route::resource('/pembayaran', PembayaranAirController::class);

    Route::get('/pembayaran-cetak', [PembayaranAirController::class, 'cetakLaporan'])->name('pembayaran.cetak');
    
});