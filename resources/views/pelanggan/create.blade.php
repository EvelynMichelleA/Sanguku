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
</style>

<div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
    <div style="max-width: 1500px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: left;">Pelanggan &gt;&gt; Tambah Pelanggan</h2>

        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf

            <!-- Nama Pelanggan -->
            <div style="margin-bottom: 15px;">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <input type="text" id="nama_pelanggan" name="nama_pelanggan" placeholder="Nama Pelanggan ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" value="{{ old('nama_pelanggan') }}" required>
                @error('nama_pelanggan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Nomor Telepon -->
            <div style="margin-bottom: 15px;">
                <label for="nomor_telepon">Nomor Telepon</label>
                <input type="text" id="nomor_telepon" name="nomor_telepon" placeholder="Nomor Telepon ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" value="{{ old('nomor_telepon') }}" required>
                @error('nomor_telepon')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Email Pelanggan -->
            <div style="margin-bottom: 15px;">
                <label for="email_pelanggan">Email Pelanggan</label>
                <input type="email" id="email_pelanggan" name="email_pelanggan" placeholder="Email ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" value="{{ old('email_pelanggan') }}" required>
                @error('email_pelanggan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px;">
                <a href="{{ route('pelanggan.index') }}" class="cancel-button">Batalkan</a>
                <button type="submit" class="submit-button">Tambah Pelanggan</button>
            </div>
        </form>
    </div>
</div>
@endsection
