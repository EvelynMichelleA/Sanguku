<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanPengeluaranController;
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\LaporanTransaksiPenjualanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('user.index');
    Route::get('/transaksi-penjualan', [TransaksiPenjualanController::class, 'index'])->name('transaksi-penjualan.index');
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/laporan-transaksi', [LaporanTransaksiPenjualanController::class, 'index'])->name('laporan-transaksi.index');
    Route::get('/laporan-pengeluaran', [LaporanPengeluaranController::class, 'index'])->name('laporan-pengeluaran.index');
});

require __DIR__.'/auth.php';
