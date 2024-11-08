@extends('layouts.app')

@section('content')
<style>
    body, input, select, label, button, a {
        font-family: 'Poppins', sans-serif;
    }
</style>
<div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
    <div style="max-width: 1500px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: left;">Pelanggan &gt;&gt; Tampil Detail Pelanggan</h2>

        <!-- Nama Pelanggan -->
        <div style="margin-bottom: 15px;">
            <label for="nama_pelanggan" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Nama Pelanggan</label>
            <input type="text" id="nama_pelanggan" class="form-control" value="{{ $pelanggan->nama_pelanggan }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Nomor Telepon -->
        <div style="margin-bottom: 15px;">
            <label for="nomor_telepon" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Nomor Telepon</label>
            <input type="text" id="nomor_telepon" class="form-control" value="{{ $pelanggan->nomor_telepon }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Email Pelanggan -->
        <div style="margin-bottom: 15px;">
            <label for="email_pelanggan" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Email Pelanggan</label>
            <input type="email" id="email_pelanggan" class="form-control" value="{{ $pelanggan->email_pelanggan }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Jumlah Poin -->
        <div style="margin-bottom: 15px;">
            <label for="jumlah_poin" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Jumlah Poin</label>
            <input type="text" id="jumlah_poin" class="form-control" value="Rp {{ number_format($pelanggan->jumlah_poin, 0, ',', '.') }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Button Kembali -->
        <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
            <a href="{{ route('pelanggan.index') }}" 
               style="padding: 10px 20px; background-color: #1e3a8a; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; text-align: center; transition: background-color 0.3s ease;"
               onmouseover="this.style.backgroundColor='#3b82f6';" 
               onmouseout="this.style.backgroundColor='#1e3a8a';">Kembali</a>
        </div>
    </div>
</div>
@endsection
