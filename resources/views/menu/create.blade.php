@extends('layouts.app')

@section('content')
<div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
    <div style="max-width: 1500px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px;">Menu >> Tambah Menu</h2>
        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 15px;">
                <label for="nama_menu" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Nama Menu</label>
                <input type="text" id="nama_menu" name="nama_menu" placeholder="Nama Menu ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="jenis_menu" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Jenis Makanan</label>
                <select id="jenis_menu" name="jenis_menu" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" required>
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Snack">Snack</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="harga" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Harga Menu</label>
                <input type="number" id="harga" name="harga" placeholder="Harga ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="gambar_menu" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Upload Image</label>
                <input type="file" id="gambar_menu" name="gambar_menu" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <a href="/menu" style="padding: 10px 20px; background-color: #d1d5db; color: #374151; text-decoration: none; border-radius: 5px; font-size: 14px; text-align: center;">Batalkan</a>
                <button type="submit" style="padding: 10px 20px; background-color: #3b82f6; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer;">Tambah Menu</button>
            </div>
        </form>
    </div>
</div>
@endsection
