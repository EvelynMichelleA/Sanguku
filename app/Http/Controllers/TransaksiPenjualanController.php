<?php 

namespace App\Http\Controllers;

use App\Models\TransaksiPenjualan;
use App\Models\Pelanggan;
use App\Models\Menu;
use Illuminate\Http\Request;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiPenjualan::with(['pelanggan', 'pengguna'])->get();
        return view('transaksi_penjualan.index', compact('transaksi'));
    }

 
}
