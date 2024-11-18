<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $pengeluaran = Pengeluaran::take(20)->get();
        $query = Pengeluaran::query();

    // Filter berdasarkan tanggal jika ada
    if ($request->start_date && $request->end_date) {
        $query->whereBetween('tanggal_pengeluaran', [$request->start_date, $request->end_date]);
    } elseif ($request->start_date) {
        $query->whereDate('tanggal_pengeluaran', '>=', $request->start_date);
    } elseif ($request->end_date) {
        $query->whereDate('tanggal_pengeluaran', '<=', $request->end_date);
    }

    $pengeluaran = $query->orderBy('tanggal_pengeluaran', 'desc')->paginate(20);
    // Kirim data ke view
    return view('pengeluaran.index', compact('pengeluaran'));
    }

    public function create()
    {
        return view('pengeluaran.create'); // Sesuaikan dengan nama view Anda
    }

    public function store(Request $request)
{
    // Validasi data
    $validatedData = $request->validate([
        'nama_pengeluaran' => 'required|string|max:255',
        'total_pengeluaran' => 'required|numeric|min:0',
        'tanggal_pengeluaran' => 'required|date',
        'keterangan_pengeluaran' => 'required|string',
    ], [
        'total_pengeluaran.numeric' => 'The price field must be a number.',
        'keterangan_pengeluaran.required' => 'Please fill this field.',
    ]);

    // Tambahkan id dari pengguna yang sedang login
    $validatedData['id'] = Auth::user()->id;

    // Simpan data ke dalam database
    Pengeluaran::create($validatedData);

    // Redirect ke halaman daftar pengeluaran dengan pesan sukses
    return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
}

public function show($id_pengeluaran)
{
    $pengeluaran = Pengeluaran::findOrFail($id_pengeluaran); // Cari berdasarkan id_pengeluaran
    return view('pengeluaran.show', compact('pengeluaran')); // Kirim data ke view
}

}
