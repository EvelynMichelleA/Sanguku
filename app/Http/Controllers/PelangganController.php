<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pelanggan = Pelanggan::query();

        if ($search) {
            $pelanggan = $pelanggan->where('nama_pelanggan', 'like', '%' . $search . '%')
                ->orWhere('nomor_telepon', 'like', '%' . $search . '%')
                ->orWhere('email_pelanggan', 'like', '%' . $search . '%');
        }
        $pelanggan = $pelanggan->paginate(20);

        return view('pelanggan.index', compact('pelanggan'));
    }
    public function create()
    {
        return view('pelanggan.create'); // Buat view pelanggan.create
    }
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15|unique:pelanggan,nomor_telepon',
            'email_pelanggan' => 'required|email|unique:pelanggan,email_pelanggan',
        ]);

        // Simpan data pelanggan
        Pelanggan::create([
            'nama_pelanggan' => $validatedData['nama_pelanggan'],
            'nomor_telepon' => $validatedData['nomor_telepon'],
            'email_pelanggan' => $validatedData['email_pelanggan'],
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id_pelanggan)
    {
        $pelanggan = \App\Models\Pelanggan::findOrFail($id_pelanggan);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id_pelanggan)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15|unique:pelanggan,nomor_telepon,' . $id_pelanggan . ',id_pelanggan',
            'email_pelanggan' => 'required|email|unique:pelanggan,email_pelanggan,' . $id_pelanggan . ',id_pelanggan',
        ]);

        // Update data pelanggan
        $pelanggan = \App\Models\Pelanggan::findOrFail($id_pelanggan);
        $pelanggan->update($validatedData);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function show($id_pelanggan)
{
    $pelanggan = \App\Models\Pelanggan::findOrFail($id_pelanggan);
    return view('pelanggan.show', compact('pelanggan'));
}
public function destroy($id_pelanggan)
{
    // Cari pelanggan berdasarkan ID
    $pelanggan = \App\Models\Pelanggan::findOrFail($id_pelanggan);

    // Hapus pelanggan
    $pelanggan->delete();

    // Redirect kembali dengan pesan sukses
    return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
}

}
