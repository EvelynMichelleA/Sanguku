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
        transition: background-color 0.3s ease; /* Smooth transition untuk hover */
    }

    .submit-button:hover {
        background-color: #3b82f6; /* Warna hover */
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
        transition: background-color 0.3s ease; /* Smooth transition */
    }

    .cancel-button:hover {
        background-color: #e5e7eb; /* Warna hover untuk tombol batal */
    }

    /* Styling Input */
    input, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    input:focus, select:focus {
        border-color: #3b82f6; /* Border biru saat fokus */
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
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: left;">Pengguna &gt;&gt; Update Pengguna</h2>

        <form action="{{ route('pengguna.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Pengguna -->
            <div style="margin-bottom: 15px;">
                <label for="name" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Nama Pengguna</label>
                <input type="text" id="name" name="name" placeholder="Nama Pengguna ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <small class="text-danger" style="font-size: 12px;">{{ $message }}</small>
                @enderror
            </div>

            <!-- Username -->
            <div style="margin-bottom: 15px;">
                <label for="username" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Username</label>
                <input type="text" id="username" name="username" placeholder="Username ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" value="{{ old('username', $user->username) }}" required>
                @error('username')
                    <small class="text-danger" style="font-size: 12px;">{{ $message }}</small>
                @enderror
            </div>

            <!-- Email -->
            <div style="margin-bottom: 15px;">
                <label for="email" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Email</label>
                <input type="email" id="email" name="email" placeholder="Email ..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <small class="text-danger" style="font-size: 12px;">{{ $message }}</small>
                @enderror
            </div>

            <!-- Role -->
            <div style="margin-bottom: 15px;">
                <label for="id_role" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Role</label>
                <select id="id_role" name="id_role" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" required>
                    @foreach ($roles as $id => $role)
                        <option value="{{ $id }}" {{ $id == old('id_role', $user->id_role) ? 'selected' : '' }}>
                            {{ $role }}
                        </option>
                    @endforeach
                </select>
                @error('id_role')
                    <small class="text-danger" style="font-size: 12px;">{{ $message }}</small>
                @enderror
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px;">
                <a href="{{ route('user.index') }}" style="padding: 10px 20px; background-color: #d1d5db; color: #374151; text-decoration: none; border-radius: 5px; font-size: 14px; text-align: center; margin-right: 10px;">Batalkan</a>
                <button type="submit" class="submit-button">Update Pengguna</button>
            </div>
        </form>
    </div>
</div>
@endsection
