@extends('layouts.app')

@section('content')
    <style>
        body,
        input,
        select,
        label,
        button,
        a {
            font-family: 'Poppins', sans-serif;
        }

        .text-danger {
            color: red;
            font-size: 12px;
        }

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

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            border-color: #3b82f6;
            outline: none;
        }

        label {
            font-weight: bold;
            color: #1e3a8a;
            display: block;
            margin-bottom: 5px;
        }
    </style>

    <div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
        <div
            style="max-width: 1500px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
            <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: left;">Transaksi
                Penjualan &gt;&gt; Tambah Transaksi</h2>

            <form action="{{ route('transaksi-penjualan.store') }}" method="POST">
                @csrf


                <!-- Nomor Pelanggan  -->
                <div style="margin-bottom: 15px;">
                    <label for="id_pelanggan">Pilih Pelanggan (Opsional)</label>
                    <select id="id_pelanggan" name="id_pelanggan">
                        <option value="" selected>Pilih Pelanggan (Opsional)</option>
                        @foreach ($pelangganItems as $pelanggan)
                            <option value="{{ $pelanggan->id_pelanggan }}">{{ $pelanggan->nama_pelanggan }} -
                                {{ $pelanggan->nomor_telepon }}</option>
                        @endforeach
                    </select>
                </div>


                <!-- Pilih Menu -->
                <div style="margin-bottom: 15px;">
                    <label for="menu">Pilih Menu</label>
                    @foreach ($menuItems as $index => $menu)
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <input type="checkbox" id="menu_{{ $menu->id_menu }}" name="menu[]"
                                value="{{ $menu->id_menu }}" style="margin-right: 10px;">
                            <label for="menu_{{ $menu->id_menu }}" style="flex-grow: 1;">{{ $menu->nama_menu }} - Rp
                                {{ number_format($menu->harga, 0, ',', '.') }}</label>
                            <input type="number" name="jumlah[]" placeholder="Jumlah" min="1" value="1"
                                style="width: 80px;">
                        </div>
                    @endforeach
                    @error('menu')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px;">
                    <a href="{{ route('transaksi-penjualan.index') }}" class="cancel-button">Batalkan</a>
                    <button type="submit" class="submit-button">Tambah Transaksi</button>
                </div>
            </form>
        </div>
    </div>
@endsection
