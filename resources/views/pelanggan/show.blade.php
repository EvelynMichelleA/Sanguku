@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Pelanggan >> Tampil Detail Pelanggan</h3>
    <div class="form-group">
        <label for="nama_pelanggan">Nama Pelanggan</label>
        <input type="text" id="nama_pelanggan" class="form-control" value="{{ $pelanggan->nama_pelanggan }}" readonly>
    </div>

    <div class="form-group">
        <label for="nomor_telepon">Nomor Telepon</label>
        <input type="text" id="nomor_telepon" class="form-control" value="{{ $pelanggan->nomor_telepon }}" readonly>
    </div>

    <div class="form-group">
        <label for="email_pelanggan">Email Pelanggan</label>
        <input type="email" id="email_pelanggan" class="form-control" value="{{ $pelanggan->email_pelanggan }}" readonly>
    </div>

    <div class="form-group">
        <label for="jumlah_poin">Jumlah Poin</label>
        <input type="text" id="jumlah_poin" class="form-control" value="Rp {{ number_format($pelanggan->jumlah_poin, 0, ',', '.') }}"
        readonly>
    </div>

    <div class="form-group mt-3">
        <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>
@endsection
