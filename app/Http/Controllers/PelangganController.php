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
}
