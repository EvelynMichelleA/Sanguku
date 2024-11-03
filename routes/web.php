<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    MenuController,
    ProfileController,
    PenggunaController,
    PelangganController,
    PengeluaranController,
    LaporanPengeluaranController,
    TransaksiPenjualanController,
    LaporanTransaksiPenjualanController
};

// Redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route yang bisa diakses oleh semua role
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route dengan akses penuh untuk Owner dan Supervisor
Route::get('/laporan-transaksi', function () {
    if (Auth::user() && (Auth::user()->role->nama_role === 'Owner' || Auth::user()->role->nama_role === 'Supervisor')) {
        return app(LaporanTransaksiPenjualanController::class)->index();
    }
    return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
})->middleware('auth')->name('laporan-transaksi.index');

Route::get('/laporan-pengeluaran', function () {
    if (Auth::user() && (Auth::user()->role->nama_role === 'Owner' || Auth::user()->role->nama_role === 'Supervisor')) {
        return app(LaporanPengeluaranController::class)->index();
    }
    return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
})->middleware('auth')->name('laporan-pengeluaran.index');

// Route "Pengguna" hanya bisa diakses oleh Owner dan Supervisor
Route::get('/pengguna', function () {
    if (Auth::user() && (Auth::user()->role->nama_role === 'Owner' || Auth::user()->role->nama_role === 'Supervisor')) {
        return app(PenggunaController::class)->index();
    }
    return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
})->middleware('auth')->name('user.index');

// Route yang bisa diakses oleh semua role (Owner, Supervisor, dan Kasir), kecuali "Pengguna" dan laporan
Route::middleware('auth')->group(function () {
    Route::get('/transaksi-penjualan', [TransaksiPenjualanController::class, 'index'])->name('transaksi-penjualan.index');
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
});

require __DIR__.'/auth.php';
