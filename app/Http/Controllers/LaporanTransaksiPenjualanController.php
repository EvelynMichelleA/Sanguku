<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TransaksiPenjualan;

class LaporanTransaksiPenjualanController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiPenjualan::with('details')->paginate(50);

        // Ambil data filter dari request global
        $tanggalDari = request('tanggal_dari');
        $tanggalSampai = request('tanggal_sampai');
        $namaPelanggan = request('nama_pelanggan');

        // Query dasar transaksi penjualan
        $query = TransaksiPenjualan::query();

        // Filter berdasarkan tanggal
        if (!empty($tanggalDari) && !empty($tanggalSampai)) {
            $tanggalDari = $tanggalDari . ' 00:00:00'; // Awal hari
            $tanggalSampai = $tanggalSampai . ' 23:59:59'; // Akhir hari
        
            $query->whereBetween('tanggal_transaksi', [$tanggalDari, $tanggalSampai]);
        }      

       // Filter berdasarkan nama pelanggan
       if (!empty($namaPelanggan)) {
           $query->whereHas('pelanggan', function ($q) use ($namaPelanggan) {
               $q->where('nama_pelanggan', 'like', "%$namaPelanggan%");
           });
       }

       // Ambil data hasil filter
       $transaksi = $query->paginate(50);

       // Ambil semua data pelanggan untuk dropdown
       $pelanggan = Pelanggan::all();

        // Kirim data ke view
        return view('laporan_transaksi_penjualan.index', compact('transaksi', 'pelanggan'));
    }

    public function exportPDF()
    {
        // Ambil parameter filter dari query string
        $start_date = request('start_date');
        $end_date = request('end_date');

        // Query dasar
        $query = TransaksiPenjualan::with('user');

        // Filter berdasarkan tanggal jika parameter tersedia
        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('tanggal_transaksi', [$start_date, $end_date]);
        } elseif (!empty($start_date)) {
            $query->whereDate('tanggal_transaksi', '>=', $start_date);
        } elseif (!empty($end_date)) {
            $query->whereDate('tanggal_transaksi', '<=', $end_date);
        }

        // Ambil semua data hasil filter
        $transaksi = $query->orderBy('tanggal_transaksi', 'desc')->get();

        // Kirim data ke view PDF
        $pdf = Pdf::loadView('laporan_transaksi_penjualan.pdf', compact('transaksi', 'start_date', 'end_date'));

        // Unduh file PDF
        return $pdf->download('laporan_transaksi.pdf');
    }

    
}
