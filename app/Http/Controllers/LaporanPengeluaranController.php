<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanPengeluaranController extends Controller
{
    public function index()
    {
        return view('laporan_pengeluaran.index');
    }
}
