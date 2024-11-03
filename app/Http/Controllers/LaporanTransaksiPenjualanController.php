<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanTransaksiPenjualanController extends Controller
{
    public function index()
    {
        return view('laporan_transaksi_penjualan.index');
    }
}
