<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\DetailTransaksiPenjualan;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiPenjualan::with('details')->paginate(10);

        // Ambil data filter dari request global
        $tanggalDari = request('tanggal_dari');
        $tanggalSampai = request('tanggal_sampai');
        $namaPelanggan = request('nama_pelanggan');

        // Query dasar transaksi penjualan
        $query = TransaksiPenjualan::query();

        // Filter berdasarkan tanggal
        if (!empty($tanggalDari) && !empty($tanggalSampai)) {
            $query->whereBetween('tanggal_transaksi', [$tanggalDari, $tanggalSampai]);
        }

        // Filter berdasarkan nama pelanggan
        if (!empty($namaPelanggan)) {
            $query->whereHas('pelanggan', function ($q) use ($namaPelanggan) {
                $q->where('nama_pelanggan', 'like', "%$namaPelanggan%");
            });
        }

        // Ambil data hasil filter
        $transaksi = $query->paginate(10);

        // Ambil semua data pelanggan untuk dropdown
        $pelanggan = Pelanggan::all();

        // Kirim data ke view
        return view('transaksi_penjualan.index', compact('transaksi', 'pelanggan'));
    }

    public function create()
    {
        $menuItems = Menu::all();
        $pelangganItems = Pelanggan::all();
        $cart = session()->get('cart', []);
        return view('transaksi_penjualan.create', compact('menuItems', 'pelangganItems', 'cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'nullable|exists:pelanggan,id_pelanggan',
            'menu' => 'required|array|min:1',
            'menu.*' => 'required|exists:menu,id_menu',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        $totalBiaya = 0;

        DB::beginTransaction();
        try {
            // Create transaksi penjualan
            $transaksiPenjualan = new TransaksiPenjualan();
            $transaksiPenjualan->id_pelanggan = $request->input('id_pelanggan'); // id_pelanggan bisa null
            $transaksiPenjualan->id_user = Auth::user()->id;
            $transaksiPenjualan->tanggal_transaksi = now();
            $transaksiPenjualan->metode_pembayaran = $request->input('metode_pembayaran', 'Cash');
            $transaksiPenjualan->total_biaya = 0; // Will be updated later
            $transaksiPenjualan->save();

            // Add details for each menu item
            foreach ($request->menu as $index => $menuId) {
                $menu = Menu::findOrFail($menuId);
                $jumlah = $request->jumlah[$index];
                $subtotal = $menu->harga * $jumlah;
                $totalBiaya += $subtotal;

                $detail = new DetailTransaksiPenjualan();
                $detail->id_transaksi_penjualan = $transaksiPenjualan->id_transaksi_penjualan;
                $detail->id_menu = $menu->id_menu;
                $detail->nama_menu = $menu->nama_menu;
                $detail->jumlah = $jumlah;
                $detail->harga_satuan = $menu->harga;
                $detail->subtotal = $subtotal;
                $detail->save();
            }

            // Update total biaya transaksi
            $transaksiPenjualan->total_biaya = $totalBiaya;
            $transaksiPenjualan->save();

            DB::commit();

            return redirect()->route('transaksi-penjualan.index')->with('success', 'Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }
    
}
