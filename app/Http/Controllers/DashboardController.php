<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use App\Models\DetailTransaksiPenjualan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // Ambil filter tahun dari request atau default ke tahun saat ini
        $tahunDipilih =  $request->input('tahun', date('Y'));

        // Hitung total penjualan per bulan untuk tahun ini menggunakan SQLite-compatible syntax
        $penjualanBulanan = TransaksiPenjualan::selectRaw("MONTH(tanggal_transaksi) as bulan, SUM(total_biaya) as total")
            ->whereYear('tanggal_transaksi', $tahunDipilih)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->mapWithKeys(function ($item) {
                return [(int)$item->bulan => $item->total];
            })
            ->toArray();

        // Pastikan semua bulan memiliki data, jika tidak ada, set menjadi 0
        $dataPenjualan = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataPenjualan[] = $penjualanBulanan[$i] ?? 0;
        }
        $penjualanKosong = count($penjualanBulanan) === 0;
        $pengeluaranBulanan = Pengeluaran::selectRaw("MONTH(tanggal_pengeluaran) as bulan, SUM(total_pengeluaran) as total")
            ->whereYear('tanggal_pengeluaran', $tahunDipilih)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->mapWithKeys(function ($item) {
                return [(int)$item->bulan => $item->total];
            })
            ->toArray();

        // Pastikan semua bulan memiliki data, jika tidak ada, set menjadi 0
        $dataPengeluaran = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataPengeluaran[] = $pengeluaranBulanan[$i] ?? 0;
        }
        $pengeluaranKosong = count($pengeluaranBulanan) === 0;

        // Ambil data untuk dashboard
        $jumlahPelanggan = Pelanggan::whereYear('created_at', $tahunDipilih)->count();
        $jumlahMenu = Menu::whereYear('created_at', $tahunDipilih)->count();
        $jumlahTransaksi = TransaksiPenjualan::whereYear('tanggal_transaksi', $tahunDipilih)->count();
        $totalPendapatan = TransaksiPenjualan::whereYear('tanggal_transaksi', $tahunDipilih)->sum('total_biaya');

        // Menghitung total pengeluaran
        $totalPengeluaran = Pengeluaran::whereYear('tanggal_pengeluaran', $tahunDipilih)->sum('total_pengeluaran');

        // Menghitung balance (profit/loss)
        $balance = $totalPendapatan - $totalPengeluaran;
        $profit = $balance >= 0 ? $balance : 0; // Profit
        $loss = $balance < 0 ? abs($balance) : 0; // Loss

        // Cek jika data balance kosong (profit dan loss)
        $balanceKosong = $balance == 0;

        // Menghitung persentase Profit dan Loss berdasarkan totalPendapatan
        $profitPercentage = $totalPendapatan > 0 ? ($profit / $totalPengeluaran) * 100 : 0;
        $lossPercentage = $totalPengeluaran > 0 ? ($loss / $totalPengeluaran) * 100 : 0;
        $noData = $jumlahTransaksi == 0 && $jumlahMenu == 0 && $jumlahPelanggan == 0;
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

        // Hitung menu terlaris
        $menuTerlaris = DetailTransaksiPenjualan::with('menu')
            ->select('id_menu', DB::raw('sum(jumlah) as total_penjualan'))
            ->whereYear('created_at', $tahunDipilih)
            ->groupBy('id_menu')
            ->orderByDesc('total_penjualan')
            ->limit(5)
            ->get();

        // Cek jika data menu terlaris kosong
        $menuTerlarisKosong = $menuTerlaris->isEmpty();

        // Ambil nama menu dan jumlah penjualannya
        $menuNames = $menuTerlaris->map(function ($item) {
            return $item->menu->nama_menu; // Ambil nama menu dari relasi
        })->toArray();

        $menuSales = $menuTerlaris->pluck('total_penjualan')->toArray();

        // Kirim data ke view
        return view('dashboard', [
            'jumlahPelanggan' => $jumlahPelanggan,
            'jumlahTransaksi' => $jumlahTransaksi,
            'totalPendapatan' => $totalPendapatan,
            'totalPengeluaran' => $totalPengeluaran,
            'balance' => $balance,
            'profit' => $profit,
            'loss' => $loss,
            'balanceKosong' => $balanceKosong,
            'profitPercentage' => $profitPercentage,
            'lossPercentage' => $lossPercentage,
            'dataPenjualan' => $dataPenjualan,
            'dataPengeluaran' => $dataPengeluaran,
            'menuNames' => $menuNames,
            'menuSales' => $menuSales,
            'tahunDipilih' => $tahunDipilih,
            'jumlahMenu' => $jumlahMenu,
            'menuTerlarisKosong' => $menuTerlarisKosong,
            'noData' => $noData,
            'penjualanKosong' => $penjualanKosong,
            'pengeluaranKosong' => $pengeluaranKosong,
        ]);
    }
}
