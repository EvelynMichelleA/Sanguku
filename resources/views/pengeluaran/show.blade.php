@extends('layouts.app') <!-- Sesuaikan dengan layout -->
@section('content')
<div class="container">
    <h2>Pengeluaran >> Tampil Detail Pengeluaran</h2>
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="user" class="form-label">User</label>
                <input type="text" class="form-control" id="user" value="{{ $pengeluaran->user->name }}" disabled>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama Pengeluaran</label>
                <input type="text" class="form-control" id="name" value="{{ $pengeluaran->nama_pengeluaran }}" disabled>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="text" class="form-control" id="date" value="{{ \Carbon\Carbon::parse($pengeluaran->tanggal_pengeluaran)->format('d/m/Y') }}" disabled>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Total</label>
                <input type="text" class="form-control" id="amount" value="Rp {{ number_format($pengeluaran->total_pengeluaran, 0, ',', '.') }}" disabled>
            </div>
            <div class="mb-3">
                <label for="details" class="form-label">Keterangan Pengeluaran</label>
                <textarea class="form-control" id="details" rows="4" disabled>{{ $pengeluaran->keterangan_pengeluaran }}</textarea>
            </div>
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
</div>
@endsection
