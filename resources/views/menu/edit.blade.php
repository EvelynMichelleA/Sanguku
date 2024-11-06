@extends('layouts.app')

{{-- @section('content') --}}
<div class="content" style="margin-left: 270px; padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
    <div style="max-width: 600px; margin-left: 20px; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); border: 1px solid #3b82f6;">
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px;">Menu >> Update Menu</h2>
        <form action="{{ route('menu.update', $menu->id_menu) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 15px;">
                <label for="nama_menu" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Nama Menu</label>
                <input type="text" id="nama_menu" name="nama_menu" value="{{ $menu->nama_menu }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="jenis_menu" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Jenis</label>
                <select id="jenis_menu" name="jenis_menu" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" required>
                    <option value="Makanan" {{ $menu->jenis_menu == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="Minuman" {{ $menu->jenis_menu == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="Snack" {{ $menu->jenis_menu == 'Snack' ? 'selected' : '' }}>Snack</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="harga" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Harga Menu</label>
                <input type="number" id="harga" name="harga" value="{{ $menu->harga }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="gambar_menu" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Upload Image</label>
                <input type="file" id="gambar_menu" name="gambar_menu" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" onchange="previewImage(event)">
                @if ($menu->gambar_menu)
                    <p style="margin-top: 10px;">Gambar saat ini: {{ $menu->gambar_menu }}</p>
                    <img id="imagePreview" src="{{ asset('path/to/images/' . $menu->gambar_menu) }}" alt="Current Image" style="max-width: 100%; margin-top: 10px; border-radius: 5px;">
                @endif
                <img id="newImagePreview" src="" alt="New Image Preview" style="max-width: 100%; margin-top: 10px; display: none; border-radius: 5px;">
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <a href="/menu" style="padding: 10px 20px; background-color: #d1d5db; color: #374151; text-decoration: none; border-radius: 5px; font-size: 14px; text-align: center;">Batalkan</a>
                <button type="submit" style="padding: 10px 20px; background-color: #3b82f6; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer;">Update Menu</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const newImage = document.getElementById('newImagePreview');
        newImage.src = URL.createObjectURL(event.target.files[0]);
        newImage.style.display = 'block'; // Tampilkan gambar setelah dipilih
    }
</script>
{{-- @endsection --}}
