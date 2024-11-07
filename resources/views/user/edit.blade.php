@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Pengguna >> Update Pengguna</h3>
    <form action="{{ route('pengguna.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Pengguna</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
            @error('username')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_role">Role</label>
            <select name="id_role" id="id_role" class="form-control" required>
                @foreach ($roles as $id => $role)
                    <option value="{{ $id }}" {{ $id == old('id_role', $user->id_role) ? 'selected' : '' }}>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
            @error('id_role')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mt-3">
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Batalkan</a>
            <button type="submit" class="btn btn-primary">Update Pengguna</button>
        </div>
    </form>
</div>
@endsection