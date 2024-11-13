<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\Auth;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiPenjualan::with('details')->paginate(10); // Pastikan relasi 'details' sudah benar
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
                $q->where('nama_pelanggan', $namaPelanggan);
            });
        }

        // Ambil data hasil filter
        $transaksi = $query->get();

        // Ambil semua data pelanggan untuk dropdown
        $pelanggan = Pelanggan::all();

        // Kirim data ke view
        return view('transaksi_penjualan.index', compact('transaksi', 'pelanggan'));
    }

    public function create()
    {
        $menus = Menu::all(); // Data menu
        $pelanggan = \App\Models\Pelanggan::all(); // Data pelanggan
        return view('transaksi_penjualan.create', compact('menus', 'pelanggan'));
    }

    public function store(Request $request)
{
    // Validasi data yang masuk
    $validatedData = $request->validate([
        'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan', // Pelanggan harus ada di tabel pelanggan
        'total_transaction' => 'required|numeric', // Total transaksi harus angka
        'menu_data' => 'required|json', // Menu data harus dalam format JSON
    ]);

    // Decode menu_data dari JSON menjadi array
    $menus = json_decode($request->menu_data, true);
    $menuIds = array_column($menus, 'menu_id');
    if (Menu::whereIn('id_menu', $menuIds)->count() !== count($menuIds)) {
        return back()->withErrors(['menu_data' => 'Beberapa ID menu tidak valid.']);
    }    
    
    try {
        // Simpan data transaksi utama ke tabel transaksi_penjualan
        $transaksi = TransaksiPenjualan::create([
            'tanggal_transaksi' => now(),
            'id' => Auth::id(), // ID user yang login
            'id_pelanggan' => $validatedData['id_pelanggan'],
            'total_biaya' => $validatedData['total_transaction'],
            'metode_pembayaran' => 'Cash', // Misalkan default Cash
        ]);

        // Simpan detail menu ke tabel detail_transaksi_penjualan
        foreach ($menus as $menu) {
            $transaksi->details()->create([
                'id_menu' => $menu['menu_id'], // ID menu
                'jumlah' => $menu['quantity'], // Jumlah yang dibeli
                'harga' => $menu['price'], // Harga satuan
            ]);
        }

        return redirect()->route('transaksi-penjualan.index')->with('success', 'Transaksi berhasil disimpan!');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
    }
}

}
