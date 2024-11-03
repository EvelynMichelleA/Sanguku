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
        $pelanggan = $pelanggan->paginate(10);

        return view('pelanggan.index', compact('pelanggan'));
    }
}
