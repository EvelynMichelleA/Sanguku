@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Pengguna >> Tampil Pengguna</h3>
    <div class="form-group">
        <label for="name">Nama Pengguna</label>
        <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" class="form-control" value="{{ $user->username }}" readonly>
    </div>

    <div class="form-group">
        <label for="email">Email Pengguna</label>
        <input type="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
    </div>

    <div class="form-group">
        <label for="role">Role</label>
        <input type="text" id="role" class="form-control" value="{{ $roles[$user->id_role] ?? 'Unknown' }}" readonly>
    </div>

    <div class="form-group mt-3">
        <a href="{{ route('user.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>
@endsection
