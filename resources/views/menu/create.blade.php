@extends('layouts.app')

@section('content')
<style>
    /* Font Poppins untuk seluruh form */
    body, input, select, label, button, a {
        font-family: 'Poppins', sans-serif;
    }

    /* Styling Error Message */
    .text-danger {
        color: red; /* Warna merah untuk error */
        font-size: 12px; /* Ukuran teks error */
    }

    /* Submit Button */
    .submit-button {
        padding: 10px 20px;
        background-color: #1e3a8a;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease; /* Smooth transition untuk hover */
    }

    .submit-button:hover {
        background-color: #3b82f6; /* Warna hover */
    }

    /* Cancel Button */
    .cancel-button {
        padding: 10px 20px;
        background-color: #d1d5db;
        color: #374151;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        text-align: center;
        margin-right: 10px;
        transition: background-color 0.3s ease; /* Smooth transition */
    }

    .cancel-button:hover {
        background-color: #e5e7eb; /* Warna hover untuk tombol batal */
    }

    /* Styling Input */
    input, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    input:focus, select:focus {
        border-color: #3b82f6; /* Border biru saat fokus */
        outline: none;
    }

    /* Label Styling */
    label {
        font-weight: bold;
        color: #1e3a8a;
        display: block;
        margin-bottom: 5px;
    }

    /* Preview Image */
    #preview-container {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    #imagePreview {
        max-width: 200px; /* Ukuran maksimal gambar */
        border-radius: 5px;
        margin-top: 10px;
        display: none; /* Awalnya tersembunyi */
    }
</style>

<div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
    <div style="max-width: 1500px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: left;">Menu &gt;&gt; Tambah Menu</h2>

        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama Menu -->
            <div style="margin-bottom: 15px;">
                <label for="nama_menu">Nama Menu</label>
                <input type="text" id="nama_menu" name="nama_menu" placeholder="Nama Menu ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" value="{{ old('nama_menu') }}" required>
                @error('nama_menu')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Jenis Menu -->
            <div style="margin-bottom: 15px;">
                <label for="jenis_menu">Jenis Menu</label>
                <select id="jenis_menu" name="jenis_menu" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Snack">Snack</option>
                </select>
                @error('jenis_menu')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Harga -->
            <div style="margin-bottom: 15px;">
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" placeholder="Harga ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" value="{{ old('harga') }}" required>
                @error('harga')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Gambar -->
            <label for="gambar_menu">Upload Gambar</label>
            <input type="file" id="gambar_menu" name="gambar_menu" accept="image/*" onchange="previewImage(event)">
            <div id="preview-container">
                <img id="imagePreview" alt="Preview Gambar">
            </div>
            <button type="submit">Tambah Menu</button>
        

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px;">
                <a href="{{ route('menu.index') }}" class="cancel-button">Batalkan</a>
                <button type="submit" class="submit-button">Tambah Menu</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview Image Function
    function previewImage(event) {
        const input = event.target;
        const imagePreview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            // Tampilkan gambar setelah file dimuat
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Tampilkan preview
            };

            reader.readAsDataURL(input.files[0]); // Membaca file
        } else {
            imagePreview.style.display = 'none'; // Sembunyikan jika tidak ada file
        }
    }
</script>
@endsection
