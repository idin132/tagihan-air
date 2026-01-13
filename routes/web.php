<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranAirController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function() {
    return view('dashboard');
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('/dashboard', DashboardController::class);
Route::resource('/pelanggan', PelangganController::class);
Route::resource('/pembayaran', PembayaranAirController::class);