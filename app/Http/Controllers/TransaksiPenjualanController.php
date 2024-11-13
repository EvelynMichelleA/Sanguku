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
        $menu = Menu::all();
        $pelanggan = Pelanggan::all();
        $cart = session()->get('cart', []); // Ambil keranjang dari session
        return view('transaksi_penjualan.create', compact('menu', 'pelanggan', 'cart'));
    }

    /**
     * Menambahkan menu ke keranjang
     */
    public function addToCart(Request $request)
    {
        $menu = Menu::findOrFail($request->id_menu);

        // Ambil keranjang dari session
        $cart = session()->get('cart', []);

        // Tambahkan item ke keranjang
        if (isset($cart[$menu->id_menu])) {
            $cart[$menu->id_menu]['jumlah'] += $request->jumlah;
            $cart[$menu->id_menu]['subtotal'] += $menu->harga * $request->jumlah;
        } else {
            $cart[$menu->id_menu] = [
                'id_menu' => $menu->id_menu,
                'nama_menu' => $menu->nama_menu,
                'harga' => $menu->harga,
                'jumlah' => $request->jumlah,
                'subtotal' => $menu->harga * $request->jumlah,
            ];
        }

        session()->put('cart', $cart); // Simpan ke session

        return redirect()->route('transaksi-penjualan.create')->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menghapus menu dari keranjang
     */
    public function removeFromCart($id_menu)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id_menu])) {
            unset($cart[$id_menu]);
            session()->put('cart', $cart); // Perbarui keranjang
        }

        return redirect()->route('transaksi-penjualan.create')->with('success', 'Menu berhasil dihapus dari keranjang.');
    }

    /**
     * Menyimpan transaksi
     */
    public function store(Request $request)
{
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('transaksi-penjualan.create')->withErrors('Keranjang masih kosong!');
    }

    $validatedData = $request->validate([
        'id_pelanggan' => 'nullable|exists:pelanggan,id_pelanggan',
        'tanggal_transaksi' => 'required|date',
    ]);

    // Hitung total harga
    $totalHarga = array_sum(array_column($cart, 'subtotal'));

    if ($request->jumlah_uang < $totalHarga) {
        return redirect()->route('transaksi-penjualan.create')->withErrors('Jumlah uang tidak mencukupi.');
    }

    $kembalian = $request->jumlah_uang - $totalHarga;

    // Simpan transaksi utama
    $transaksi = TransaksiPenjualan::create([
        'id_pelanggan' => $validatedData['id_pelanggan'],
        'tanggal_penjualan' => $validatedData['tanggal_transaksi'],
        'total_biaya' => $totalHarga,
        'jumlah_uang' => $request->jumlah_uang,
        'kembalian' => $kembalian,
        'id_user' => Auth::id(),
        'metode_pembayaran' => $request->metode_pembayaran, 
    ]);

    // Simpan detail transaksi
    foreach ($cart as $item) {
        $transaksi->details()->create([
            'id_menu' => $item['id_menu'],
            'nama_menu' => $item['nama_menu'],
            'jumlah' => $item['jumlah'],
            'harga_satuan' => $item['harga'],
            'subtotal' => $item['subtotal'],
        ]);
    }

    session()->forget('cart'); // Kosongkan keranjang

    return redirect()->route('transaksi-penjualan.index')->with('success', 'Transaksi berhasil disimpan.');
}

    
    
    // public function print($id_transaksi_penjualan)
    // {
    //     $transaction = TransaksiPenjualan::with('pelanggan', 'user')->findOrFail($id_transaksi_penjualan);

    //     // Optional: Generate PDF or return a printable view
    //     return view('transaksipenjualan.print', compact('transaction'));
    // }
    // public function destroy($id_transaksi_penjualan)
    // {
    //     $transaksipenjualan = TransaksiPenjualan::findOrFail($id_transaksi_penjualan);

    //     try {
    //         $transaksipenjualan->delete(); // Menghapus data dengan soft delete (jika diaktifkan)
    //         return redirect()->route('transakasipenjualan.index')->with('success', 'Data transaksi penjualan berhasil dihapus.');
    //     } catch (\Exception $e) {
    //         return redirect()->route('transaksipenjualan.index')->withErrors('Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
    //     }
    // }

    public function show($id_transaksi_penjualan)
{
    $transaksi = TransaksiPenjualan::with(['user', 'pelanggan'])->findOrFail($id_transaksi_penjualan);
    return view('transaksi_penjualan.show', compact('transaksi'));
}
    
}
