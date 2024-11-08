<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\Auth;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiPenjualan::with('details')->paginate(10); // Pastikan relasi 'details' sudah benar
        return view('transaksi_penjualan.index', compact('transaksi'));
    }

    public function create()
    {
        $menus = Menu::all(); // Data menu
        $pelanggan = \App\Models\Pelanggan::all(); // Data pelanggan
        return view('transaksi_penjualan.create', compact('menus', 'pelanggan'));
    }

    // public function confirm(Request $request)
    // {
    //     // Ambil data dari request untuk ditampilkan di halaman konfirmasi pembayaran
    //     $totalTransaction = $request->input('total_transaction');
    //     $menuData = json_decode($request->input('menu_data'), true);

    //     // Ambil kembali informasi menu berdasarkan ID
    //     $menus = [];
    //     foreach ($menuData as $menu) {
    //         $menuDetails = Menu::find($menu['menu_id']);
    //         if ($menuDetails) {
    //             $menus[] = [
    //                 'id_menu' => $menuDetails->id,
    //                 'nama_menu' => $menuDetails->nama_menu,
    //                 'quantity' => $menu['quantity'],
    //                 'price' => $menu['price'],
    //             ];
    //         }
    //     }

    //     return view('transaksi_penjualan.confirm', compact('totalTransaction', 'menus'));
    // }

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
