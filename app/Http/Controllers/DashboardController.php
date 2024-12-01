<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller{
public function dashboard(Request $request)
{
    // Ambil filter tahun dari request atau default ke tahun saat ini
    $tahunDipilih = $request->get('tahun', Carbon::now()->year);

    // Ambil data untuk dashboard
    $jumlahPelanggan = Pelanggan::count();
        $jumlahTransaksi = TransaksiPenjualan::whereYear('tanggal_transaksi', $tahunDipilih)->count();
        $totalPendapatan = TransaksiPenjualan::whereYear('tanggal_transaksi', $tahunDipilih)->sum('total_biaya');
        $bulanIniPendapatan = TransaksiPenjualan::whereYear('tanggal_transaksi', $tahunDipilih)
            ->whereMonth('tanggal_transaksi', Carbon::now()->month)
            ->sum('total_biaya');

        // Menghitung total pengeluaran
        $totalPengeluaran = Pengeluaran::whereYear('tanggal_pengeluaran', $tahunDipilih)->sum('total_pengeluaran');
        $bulanIniPengeluaran = Pengeluaran::whereYear('tanggal_pengeluaran', $tahunDipilih)
            ->whereMonth('tanggal_pengeluaran', Carbon::now()->month)
            ->sum('total_pengeluaran');

    // Menghitung balance (profit/loss)
    $balance = $totalPendapatan - $totalPengeluaran;
    $profit = $balance >= 0 ? $balance : 0; // Profit
    $loss = $balance < 0 ? abs($balance) : 0; // Loss

    // Ambil data penjualan dan pengeluaran bulanan untuk grafik
    $dataPenjualan = [];
    for ($month = 1; $month <= 12; $month++) {
        $dataPenjualan[] = TransaksiPenjualan::whereYear('tanggal_transaksi', $tahunDipilih)
            ->whereMonth('tanggal_transaksi', $month)
            ->sum('total_biaya');
    }

    $dataPengeluaran = [];
    for ($month = 1; $month <= 12; $month++) {
        $dataPengeluaran[] = Pengeluaran::whereYear('tanggal_pengeluaran', $tahunDipilih)
            ->whereMonth('tanggal_pengeluaran', $month)
            ->sum('total_pengeluaran');
    }

    // Menu terlaris
    $menuSalesData = DB::table('detail_transaksi_penjualans')
        ->select('id_menu', DB::raw('COUNT(id_menu) as total_sales'))
        ->groupBy('id_menu')
        ->orderByDesc('total_sales')
        ->limit(10)
        ->get();

    // Ambil nama menu berdasarkan id_menu
    $menuNames = Menu::whereIn('id', $menuSalesData->pluck('id_menu'))->pluck('nama_menu')->toArray();
    $menuSales = $menuSalesData->pluck('total_sales')->toArray();

    // Kirim data ke view
    return view('dashboard', [
        'jumlahPelanggan' => $jumlahPelanggan,
        'jumlahTransaksi' => $jumlahTransaksi,
        'totalPendapatan' => $totalPendapatan,
        'bulanIniPendapatan' => $bulanIniPendapatan,
        'totalPengeluaran' => $totalPengeluaran,
        'bulanIniPengeluaran' => $bulanIniPengeluaran,
        'balance' => $balance,
        'profit' => $profit,
        'loss' => $loss,
        'dataPenjualan' => $dataPenjualan,
        'dataPengeluaran' => $dataPengeluaran,
        'menuNames' => $menuNames,
        'menuSales' => $menuSales,
        'tahunDipilih' => $tahunDipilih,
    ]);
}}
