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
        transition: background-color 0.3s ease;
    }

    .submit-button:hover {
        background-color: #3b82f6;
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
        transition: background-color 0.3s ease;
    }

    .cancel-button:hover {
        background-color: #e5e7eb;
    }

    /* Styling Input */
    input, textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    input:focus, textarea:focus {
        border-color: #3b82f6;
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
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: left;">Pengeluaran &gt;&gt; Tambah Pengeluaran</h2>

        <form action="{{ route('pengeluaran.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ auth()->user()->id }}">

            <!-- Nama Pengeluaran -->
            <div style="margin-bottom: 15px;">
                <label for="nama_pengeluaran">Nama Pengeluaran</label>
                <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" placeholder="Nama Pengeluaran ..."style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" value="{{ old('nama_pengeluaran') }}" required>
                @error('nama_pengeluaran')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Total Pengeluaran -->
            <div style="margin-bottom: 15px;">
                <label for="total_pengeluaran">Total Pengeluaran</label>
                <input type="number" name="total_pengeluaran" id="total_pengeluaran" placeholder="Total Pengeluaran ..."style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" value="{{ old('total_pengeluaran') }}" required>
                @error('total_pengeluaran')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Tanggal Pengeluaran -->
            <div style="margin-bottom: 15px;">
                <label for="tanggal_pengeluaran">Tanggal Pengeluaran</label>
                <input type="date" name="tanggal_pengeluaran" id="tanggal_pengeluaran" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;"value="{{ old('tanggal_pengeluaran') }}" required>
                @error('tanggal_pengeluaran')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Keterangan Pengeluaran -->
            <div style="margin-bottom: 15px;">
                <label for="keterangan_pengeluaran">Keterangan</label>
                <textarea name="keterangan_pengeluaran" id="keterangan_pengeluaran" placeholder="Tambahkan keterangan ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">{{ old('keterangan_pengeluaran') }}</textarea>
                @error('keterangan_pengeluaran')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px;">
                <a href="{{ route('pengeluaran.index') }}" class="cancel-button">Batalkan</a>
                <button type="submit" class="submit-button">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
