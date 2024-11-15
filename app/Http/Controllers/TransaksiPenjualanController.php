<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use App\Models\DetailTransaksiPenjualan;

class TransaksiPenjualanController extends Controller
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
        return view('transaksi_penjualan.index', compact('transaksi', 'pelanggan'));
    }

    public function create()
    {
        $menu = Menu::all();
        $pelanggan = Pelanggan::all();
        $cart = session()->get('cart', []); // Ambil keranjang dari session
        return view('transaksi_penjualan.create', compact('menu', 'pelanggan', 'cart'));
    }

    public function store(Request $request)
{
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('transaksi-penjualan.create')->withErrors('Keranjang masih kosong!');
    }

    $validatedData = $request->validate([
        'id_pelanggan' => 'nullable|exists:pelanggan,id_pelanggan',
        'tanggal_transaksi' => 'required|date',
        'metode_pembayaran' => 'required',
        'jumlah_uang' => 'required|numeric|min:0',
        'gunakan_poin' => 'nullable|boolean',
    ]);

    // Hitung total harga sebelum diskon
    $totalHargaSebelumDiskon = array_sum(array_column($cart, 'subtotal'));
    $totalHargaAsli = $totalHargaSebelumDiskon; // Simpan nilai asli sebelum diskon diterapkan
    $diskon = 0;
    $jumlahPoinDigunakan = 0;

    if ($request->gunakan_poin && $request->id_pelanggan) {
        $pelanggan = Pelanggan::find($request->id_pelanggan);

        if ($pelanggan) {
            $jumlahPoin = $pelanggan->jumlah_poin;
            $diskon = $jumlahPoin;
            $jumlahPoinDigunakan = $jumlahPoin;

            // Jika diskon lebih besar dari total biaya, sesuaikan diskon
            if ($diskon > $totalHargaSebelumDiskon) {
                $jumlahPoinDigunakan = floor($totalHargaSebelumDiskon); // Hitung poin yang digunakan
                $diskon = $jumlahPoinDigunakan;
            }

            // Kurangi total harga dengan diskon
            $totalHargaSebelumDiskon -= $diskon;

            // Kurangi poin pelanggan
            $pelanggan->decrement('jumlah_poin', $jumlahPoinDigunakan);
        }
    }

    // Hitung total biaya setelah diskon
    $totalBiayaSetelahDiskon = max(0, $totalHargaSebelumDiskon);

    if ($request->jumlah_uang < $totalBiayaSetelahDiskon) {
        return redirect()->route('transaksi-penjualan.create')->withErrors('Jumlah uang tidak mencukupi.');
    }

    $kembalian = $request->jumlah_uang - $totalBiayaSetelahDiskon;

    // Simpan transaksi utama
    $transaksi = TransaksiPenjualan::create([
        'id_pelanggan' => $request->id_pelanggan,
        'tanggal_penjualan' => $request->tanggal_transaksi,
        'total_biaya' => $totalBiayaSetelahDiskon,
        'diskon' => $diskon,
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

    // Tambahkan poin baru ke pelanggan (5% dari total biaya sebelum diskon)
    if ($request->id_pelanggan) {
        $pelanggan = Pelanggan::find($request->id_pelanggan);
        if ($pelanggan) {
            $poinBaru = floor($totalHargaAsli * 0.05); // 5% dari total biaya sebelum diskon
            $pelanggan->increment('jumlah_poin', $poinBaru);
        }
    }

    session()->forget('cart'); // Kosongkan keranjang

    return redirect()->route('transaksi-penjualan.index')->with('success', 'Transaksi berhasil disimpan.');
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

    public function show($id_transaksi_penjualan)
    {
        $transaksi = TransaksiPenjualan::with(['user', 'pelanggan'])->findOrFail($id_transaksi_penjualan);
        return view('transaksi_penjualan.show', compact('transaksi'));
    }

    public function cetak($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = TransaksiPenjualan::with(['details', 'user', 'pelanggan'])->findOrFail($id);

        // Siapkan data untuk cetak nota
        $data = [
            'transaksi' => $transaksi,
        ];

        // Gunakan PDF untuk menghasilkan file
        $pdf = Pdf::loadView('transaksi_penjualan.cetaknota', $data);

        // Unduh atau tampilkan PDF
        return $pdf->stream('nota-transaksi-' . $id . '.pdf');
    }
}
