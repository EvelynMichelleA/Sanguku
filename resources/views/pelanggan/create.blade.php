@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Pelanggan</h3>
    <form action="{{ route('pelanggan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" value="{{ old('nama_pelanggan') }}" required>
            @error('nama_pelanggan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="nomor_telepon">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control" value="{{ old('nomor_telepon') }}" required>
            @error('nomor_telepon')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email_pelanggan">Email Pelanggan</label>
            <input type="email" name="email_pelanggan" id="email_pelanggan" class="form-control" value="{{ old('email_pelanggan') }}" required>
            @error('email_pelanggan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mt-3">
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
