<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        // Ambil semua data pengguna dengan relasi ke tabel 'role'
        $users = User::with('role')->get();
    
        // Kirim data ke view
        return view('user.index', compact('users'));
    }
    
}
