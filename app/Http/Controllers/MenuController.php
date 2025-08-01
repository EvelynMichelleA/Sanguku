<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $menu = Menu::when($search, function ($query, $search) {
            return $query->where('nama_menu', 'like', $search . '%');
        })->paginate(20);

        return view('menu.index', compact('menu', 'search'));
    }
    public function create()
    {
        return view('menu.create'); // Mengarahkan ke halaman tambah menu
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menu,nama_menu',
            'jenis_menu' => 'required|string',
            'harga' => 'required|numeric',
            'gambar_menu' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'harga.numeric' => 'The price field must be a number.',
            'nama_menu.unique' => 'The name has been taken.',
            'gambar_menu.required'=> 'Please fill this field.',
        ]);

        $gambarMenu = null;

        if ($request->hasFile('gambar_menu')) {
            $file = $request->file('gambar_menu');
            $filename = time() . '_' . $file->getClientOriginalName(); // Tambahkan timestamp agar tetap unik
            $file->move(public_path('img/'), $filename); // Simpan di folder public/img/menu
            $gambarMenu = $filename; // Simpan nama file untuk disimpan di database
        }

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'jenis_menu' => $request->jenis_menu,
            'harga' => $request->harga,
            'gambar_menu' => $gambarMenu,
        ]);

        return redirect('/menu')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id_menu)
    {
        $menu = Menu::findOrFail($id_menu);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id_menu)
    {
        $menu = Menu::findOrFail($id_menu);

        $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menu,nama_menu'.$id_menu,
            'jenis_menu' => 'required|string',
            'harga' => 'required|numeric',
            'gambar_menu' => 'image|mimes:jpeg,png,jpg,gif|max:2048'.$id_menu,
        ], [
            'harga.numeric' => 'The price field must be a number.',
            'nama_menu.unique' => 'The name has been taken.',
            'gambar_menu.required'=> 'Please fill this field.',
        ]);

        $menu->nama_menu = $request->nama_menu;
        $menu->jenis_menu = $request->jenis_menu;
        $menu->harga = $request->harga;

        if ($request->hasFile('gambar_menu')) {
            if ($menu->gambar_menu && file_exists(public_path('img' . $menu->gambar_menu))) {
                unlink(public_path('img/' . $menu->gambar_menu)); // Hapus file lama jika ada
            }
        
            $file = $request->file('gambar_menu');
            $filename = time() . '_' . $file->getClientOriginalName(); // Gunakan nama asli dengan timestamp
            $file->move(public_path('img/'), $filename);
            $menu->gambar_menu = $filename;
        }
        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diupdate!');
    }

    public function show($id_menu)
    {
        $menu = Menu::findOrFail($id_menu);
        return view('menu.show', compact('menu'));
    }

    public function destroy($id_menu)
    {
        $menu = Menu::findOrFail($id_menu); // Gunakan id_menu jika itu nama kolom

        if ($menu->gambar_menu && file_exists(public_path('img/' . $menu->gambar_menu))) {
            unlink(public_path('img/' . $menu->gambar_menu));
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
