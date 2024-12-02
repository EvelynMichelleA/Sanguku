<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
use App\Models\TransaksiPenjualan;
use App\Models\DetailTransaksiPenjualan;
use App\Models\Pengeluaran;
use App\Models\Menu;
use Carbon\Carbon;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Middleware\CheckRole;
use App\Http\Controllers\DashboardController;

// Redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard']
)->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('/pengeluaran/create', [PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::get('/pengeluaran/{id}/detail', [PengeluaranController::class, 'show'])->name('pengeluaran.show');
    Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');
});

// Route untuk resource controller
Route::middleware('auth')->group(function () {
    Route::resource('pengeluaran', PengeluaranController::class);
});

// Routes untuk Pengguna
Route::get('/pengguna/create', [PenggunaController::class, 'create'])->name('pengguna.create');
Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
Route::get('/pengguna/{id}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');
Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
Route::get('/pengguna/{id}', [PenggunaController::class, 'show'])->name('pengguna.show');
Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

// Routes untuk Pelanggan
Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
Route::get('/pelanggan/{id_pelanggan}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
Route::put('/pelanggan/{id_pelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');
Route::get('/pelanggan/{id_pelanggan}', [PelangganController::class, 'show'])->name('pelanggan.show');
Route::delete('/pelanggan/{id_pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

// Routes untuk Menu
Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
Route::get('/menu/{id_menu}/edit', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/menu/{id_menu}', [MenuController::class, 'update'])->name('menu.update');
Route::get('/menu/{id_menu}/show', [MenuController::class, 'show'])->name('menu.show');
Route::delete('/menu/{id_menu}', [MenuController::class, 'destroy'])->name('menu.destroy');

//Routes untuk Transaksi Penjualan
Route::prefix('transaksi-penjualan')->name('transaksi-penjualan.')->group(function () {
    // Menampilkan daftar transaksi penjualan
    Route::get('/', [TransaksiPenjualanController::class, 'index'])->name('index');

    // Menampilkan form untuk membuat transaksi penjualan baru
    Route::get('/create', [TransaksiPenjualanController::class, 'create'])->name('create');

    // Menyimpan transaksi penjualan baru
    Route::post('/store', [TransaksiPenjualanController::class, 'store'])->name('store');

    // Menambahkan item ke keranjang
    Route::post('/add-to-cart', [TransaksiPenjualanController::class, 'addToCart'])->name('addToCart');

    // Menghapus item dari keranjang
    Route::get('/remove-from-cart/{id_menu}', [TransaksiPenjualanController::class, 'removeFromCart'])->name('removeFromCart');
    Route::get('/{id_transaksi_penjualan}/show', [TransaksiPenjualanController::class, 'show'])->name('show');
    Route::get('/{id_transaksi_penjualan}/cetak', [TransaksiPenjualanController::class, 'cetak'])->name('cetak');
    Route::post('/send-email/{id}', [TransaksiPenjualanController::class, 'sendEmail'])->name('sendEmail');
});

Route::get('/laporan-pengeluaran', [LaporanPengeluaranController::class, 'index'])->name('laporan-pengeluaran.index');
Route::get('laporan-pengeluaran/export-pdf', [LaporanPengeluaranController::class, 'exportPDF'])->name('laporan-pengeluaran.exportPDF');

Route::get('/laporan-transaksi', [LaporanTransaksiPenjualanController::class, 'index'])->name('laporan-transaksi.index');
Route::get('laporan-transaksi/export-pdf', [LaporanTransaksiPenjualanController::class, 'exportPDF'])->name('laporan-transaksi.exportPDF');

// Route::get('test', function(){
// \Illuminate\Support\Facades\Mail::to('michelleaurelia1544@gmail.com')->send(
//     new \App\Mail\InfoPoin ($pelanggan, )
// );
// return 'Done';

// });
// Auth routes
require __DIR__ . '/auth.php';
