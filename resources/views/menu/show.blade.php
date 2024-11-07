@extends('layouts.app')

@section('content')
<div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
    <div style="max-width: 1500px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px;">Menu >> Tampil Menu</h2>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Nama Menu</label>
            <input type="text" value="{{ $menu->nama_menu }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" readonly>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Jenis Makanan</label>
            <input type="text" value="{{ $menu->jenis_menu }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" readonly>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Harga Menu</label>
            <input type="text" value="Rp {{ number_format($menu->harga, 0, ',', '.') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" readonly>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Gambar</label>
            @if($menu->gambar_menu)
                <img src="{{ asset('img/' . $menu->gambar_menu) }}" alt="{{ $menu->nama_menu }}" style="max-width: 100%; border-radius: 5px;">
            @else
                <p>Tidak ada gambar.</p>
            @endif
        </div>

        <a href="{{ route('menu.index') }}" style="padding: 10px 20px; background-color: #3b82f6; color: white; border-radius: 5px; text-decoration: none;">Kembali</a>
    </div>
</div>
@endsection
