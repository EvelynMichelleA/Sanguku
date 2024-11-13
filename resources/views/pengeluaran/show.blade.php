@extends('layouts.app')

@section('content')
<style>
    body, input, select, label, button, a {
        font-family: 'Poppins', sans-serif;
    }
</style>
<div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
    <div style="max-width: 1500px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: left;">Pengeluaran &gt;&gt; Tampil Detail Pengeluaran</h2>

        <!-- User -->
        <div style="margin-bottom: 15px;">
            <label for="user" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">User</label>
            <input type="text" id="user" value="{{ $pengeluaran->user->name }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Nama Pengeluaran -->
        <div style="margin-bottom: 15px;">
            <label for="name" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Nama Pengeluaran</label>
            <input type="text" id="name" value="{{ $pengeluaran->nama_pengeluaran }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Tanggal Pengeluaran -->
        <div style="margin-bottom: 15px;">
            <label for="date" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Tanggal</label>
            <input type="text" id="date" value="{{ \Carbon\Carbon::parse($pengeluaran->tanggal_pengeluaran)->format('d/m/Y') }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Total Pengeluaran -->
        <div style="margin-bottom: 15px;">
            <label for="amount" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Total</label>
            <input type="text" id="amount" value="Rp {{ number_format($pengeluaran->total_pengeluaran, 0, ',', '.') }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Keterangan Pengeluaran -->
        <div style="margin-bottom: 15px;">
            <label for="details" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Keterangan Pengeluaran</label>
            <textarea id="details" rows="4" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">{{ $pengeluaran->keterangan_pengeluaran }}</textarea>
        </div>

        <!-- Button Kembali -->
        <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
            <a href="{{ route('pengeluaran.index') }}" 
               style="padding: 10px 20px; background-color: #1e3a8a; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; text-align: center; transition: background-color 0.3s ease;"
               onmouseover="this.style.backgroundColor='#3b82f6';" 
               onmouseout="this.style.backgroundColor='#1e3a8a';">Kembali</a>
        </div>
    </div>
</div>
@endsection
