<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        // Ambil semua data pengguna dengan relasi ke tabel 'role'
        $users = User::with('role')->get();
    
        // Kirim data ke view
        return view('user.index', compact('users'));
    }
    public function create()
    {
        return view('user.create'); // Sesuaikan dengan nama view
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username', // Validasi username
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'id_role' => 'required|integer|exists:role,id_role', // Validasi id_role
        ]);
        User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'], // Simpan username
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Enkripsi password
            'id_role' => $validatedData['id_role'], // Simpan id_role
        ]);
        // Redirect dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
{
    $user = User::findOrFail($id); // Ambil pengguna berdasarkan ID
    $roles = [
        1 => 'Kasir',
        2 => 'Owner',
        3 => 'Supervisor',
    ]; // List role
    return view('user.edit', compact('user', 'roles'));
}

public function update(Request $request, $id)
{
    // Validasi data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $id, // Validasi username unik
        'email' => 'required|email|unique:users,email,' . $id, // Validasi email unik
        'id_role' => 'required|integer|exists:role,id_role',
    ]);

    // Update pengguna
    $user = User::findOrFail($id);
    $user->update([
        'name' => $validatedData['name'],
        'username' => $validatedData['username'],
        'email' => $validatedData['email'],
        'id_role' => $validatedData['id_role'],
    ]);

    return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
}

public function show($id)
{
    $user = User::findOrFail($id); // Ambil data pengguna berdasarkan ID
    $roles = [
        1 => 'Kasir',
        2 => 'Owner',
        3 => 'Supervisor',
    ]; // Role mapping
    return view('user.show', compact('user', 'roles'));
}

public function destroy($id)
{
    $user = User::findOrFail($id); // Cari data pengguna berdasarkan ID
    $user->delete(); // Hapus data
    return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
}
    
}
