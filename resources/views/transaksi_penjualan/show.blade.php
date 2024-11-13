@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-primary mb-4">Detail Transaksi Penjualan</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Transaksi</h5>
            <p><strong>User:</strong> {{ $transaksi->user->name }}</p>
            <p><strong>Nama Pelanggan:</strong> {{ $transaksi->pelanggan->nama_pelanggan ?? 'Guest' }}</p>
            <p><strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ $transaksi->metode_pembayaran }}</p>
            <p><strong>Total Bayar:</strong> Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</p>
            <p><strong>Jumlah Uang:</strong> Rp {{ number_format($transaksi->jumlah_uang, 0, ',', '.') }}</p>
            <p><strong>Kembalian:</strong> Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>
        </div>
    </div>

    <h5 class="text-primary mb-3">Detail Menu</h5>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Menu</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
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

    <a href="{{ route('transaksi-penjualan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
