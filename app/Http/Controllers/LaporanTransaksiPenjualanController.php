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
        return view('laporan_transaksi_penjualan.index', compact('transaksi', 'pelanggan',  'tanggalDari', 'tanggalSampai'));
    }

    public function exportPDF()
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

        // Kirim data ke view PDF
        $pdf = Pdf::loadView('laporan_transaksi_penjualan.pdf', compact('transaksi', 'pelanggan'));

        // Unduh file PDF
        return $pdf->download('laporan_transaksi.pdf');
    }

    
}
