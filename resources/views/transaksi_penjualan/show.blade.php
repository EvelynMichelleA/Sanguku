@extends('layouts.app')

@section('content')
    <style>
        body,
        input,
        label,
        a {
            font-family: 'Poppins', sans-serif;
        }

        .align-input {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-align: center;
            height: 38px;
            line-height: 38px;
            padding: 0;
        }

        .custom-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .custom-header {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 20px;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            /* Ukuran font lebih besar */
            margin-bottom: 20px;
        }

        .large-table {
            table-layout: fixed;
            /* Memastikan kolom seimbang */
            width: 95%;
            /* Lebar tabel lebih besar */
            margin: 0 auto;
            /* Tabel berada di tengah */
        }

        .custom-table th,
        .custom-table td {
            padding: 12px 16px;
            /* Padding lebih besar untuk ukuran tabel */
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .custom-table th {
            background-color: #f1f5f9;
            /* Latar belakang header tabel */
            font-weight: bold;
            color: #1e3a8a;
        }

        .custom-table tbody tr:hover {
            background-color: #f9fafb;
            /* Efek hover pada baris */
        }

        .custom-label {
            font-weight: bold;
            color: #1e3a8a;
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        .btn-custom {
            background-color: #1e3a8a;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #3b82f6;
        }

        .info-row {
            display: flex;
            gap: 20px;
        }

        .info-col {
            flex: 1;
        }
    </style>
    <div class="container mt-5 p-4" style="background-color: #e7f0fb; border-radius: 8px;">
        <h5 class="custom-header">Transaksi Penjualan » Tampil Transaksi Penjualan</h5>

        <!-- User Information -->
        <div class="custom-card mb-4">
            <div class="info-row">
                <div class="info-col">
                    <label class="custom-label">User</label>
                    <input type="text" class="form-control align-input" value="{{ $transaksi->user->name }}" readonly>
                </div>
                <div class="info-col">
                    <label class="custom-label">Tanggal</label>
                    <input type="text" class="form-control align-input"
                        value="{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d / m / Y') }}" readonly>
                </div>
                <div class="info-col">
                    <label class="custom-label">No Pelanggan</label>
                    <input type="text" class="form-control align-input"
                        value="{{ $transaksi->pelanggan->nomor_telepon ?? 'N/A' }}" readonly>
                </div>
            </div>
        </div>

        <!-- Menu Details -->
        <div class="custom-card mb-4">
            <table class="custom-table large-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 50%;">Menu</th>
                        <th style="width: 15%;">Harga</th>
                        <th style="width: 10%;">Jumlah</th>
                        <th style="width: 20%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->nama_menu }}</td>
                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Payment Info -->
        <div class="row mt-4">
            <div class="col-md-6 mb-3">
                <label class="custom-label">Metode Bayar</label>
                <input type="text" class="form-control align-input" value="{{ $transaksi->metode_pembayaran }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label class="custom-label">Total Biaya</label>
                <input type="text" class="form-control align-input"
                    value="Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}" readonly>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-4 text-end">
            <a href="{{ route('transaksi-penjualan.index') }}" class="btn-custom">Kembali</a>
        </div>
    </div>
@endsection
