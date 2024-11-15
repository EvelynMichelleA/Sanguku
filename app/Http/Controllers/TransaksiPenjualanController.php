<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\PoinPelangganEmail;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
    // Get the cart from session
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('transaksi-penjualan.create')->withErrors('Keranjang masih kosong!');
    }

    // Calculate the subtotal (total price before discount)
    $totalHargaSebelumDiskon = array_sum(array_column($cart, 'subtotal'));  // Sum the subtotals of the cart
    $totalHargaAsli = $totalHargaSebelumDiskon;  // Store original subtotal before any discount
    $jumlahPoinDigunakan = 0;

    // Apply discount if points are used
    if ($request->gunakan_poin && $request->id_pelanggan) {
        $pelanggan = Pelanggan::find($request->id_pelanggan);

        if ($pelanggan) {
            $jumlahPoin = $pelanggan->jumlah_poin;
            $diskon = $jumlahPoin;
            $jumlahPoinDigunakan = $jumlahPoin;

            // If discount is more than the total price, adjust the discount
            if ($diskon > $totalHargaSebelumDiskon) {
                $jumlahPoinDigunakan = floor($totalHargaSebelumDiskon); // Use points equivalent to the total
                $diskon = $jumlahPoinDigunakan;
            }

            // Subtract the discount from the total price
            $totalHargaSebelumDiskon -= $diskon;

            // Deduct the used points from the customer
            $pelanggan->decrement('jumlah_poin', $jumlahPoinDigunakan);
        }
    }

    // Calculate the total cost after discount
    $totalBiayaSetelahDiskon = max(0, $totalHargaSebelumDiskon);

    // Validate the amount provided by the user
    if ($request->jumlah_uang < $totalBiayaSetelahDiskon) {
        return redirect()->route('transaksi-penjualan.create')->withErrors('Jumlah uang tidak mencukupi.');
    }

    $kembalian = $request->jumlah_uang - $totalBiayaSetelahDiskon;

    $diskon = $request->input('diskon', 0);
    // Ensure the values for subtotal and diskon are not missing
    $subtotal = $totalHargaAsli ?: 0; // Default to 0 if not set
    $diskon = $diskon ?: 0; // Default to 0 if not set
   
    // Save the main transaction with subtotal and discount
    $transaksi = TransaksiPenjualan::create([
        'id_pelanggan' => $request->id_pelanggan,
        'tanggal_penjualan' => $request->tanggal_transaksi,
        'total_biaya' => $totalBiayaSetelahDiskon,
        'diskon' => $jumlahPoinDigunakan, // Save the discount (points used)
        'subtotal' => $totalHargaSebelumDiskon,  // Save the subtotal before discount
        'jumlah_uang' => $request->jumlah_uang,
        'kembalian' => $kembalian,
        'id_user' => Auth::id(),
        'metode_pembayaran' => $request->metode_pembayaran,
    ]);

    // Save the transaction details (items in the cart)
    foreach ($cart as $item) {
        $transaksi->details()->create([
            'id_menu' => $item['id_menu'],
            'nama_menu' => $item['nama_menu'],
            'jumlah' => $item['jumlah'],
            'harga_satuan' => $item['harga'],
            'subtotal' => $item['subtotal'],
        ]);
    }

    // Add points to the customer (5% of the total price before discount)
    if ($request->id_pelanggan) {
        $pelanggan = Pelanggan::find($request->id_pelanggan);
        if ($pelanggan) {
            $poinBaru = floor($totalHargaAsli * 0.05); // 5% of the total price before discount
            $pelanggan->increment('jumlah_poin', $poinBaru);
        }
    }

    session()->forget('cart'); // Clear the cart after the transaction is saved

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

    public function sendEmail($id)
{
    // Ambil data transaksi berdasarkan ID
    $transaksi = TransaksiPenjualan::with('pelanggan')->findOrFail($id);

    // Pastikan transaksi memiliki pelanggan
    if ($transaksi->id_pelanggan && $transaksi->pelanggan) {
        $pelanggan = $transaksi->pelanggan;

        // Data poin pelanggan
        $poinSebelum = $pelanggan->jumlah_poin - floor($transaksi->total_biaya * 0.05);
        $poinDihasilkan = floor($transaksi->total_biaya * 0.05);
        $poinDigunakan = $transaksi->diskon;

        // Periksa apakah email pelanggan tersedia
        if (!empty($pelanggan->email)) {
            // Kirim email menggunakan Mailable
            Mail::to($pelanggan->email)->send(new PoinPelangganEmail($pelanggan, $poinSebelum, $poinDigunakan, $poinDihasilkan));

            return redirect()->back()->with('success', 'Email berhasil dikirim.');
        } else {
            return redirect()->back()->withErrors('Pelanggan tidak memiliki email.');
        }
    } else {
        return redirect()->back()->withErrors('Transaksi tidak memiliki data pelanggan.');
    }
}
}
