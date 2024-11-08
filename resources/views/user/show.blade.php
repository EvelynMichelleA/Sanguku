@extends('layouts.app')

@section('content')
<style>
     body, input, select, label, button, a {
        font-family: 'Poppins', sans-serif;
    }
</style>
<div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
    <div style="max-width: 1500px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: left;">Pengguna &gt;&gt; Tampil Detail Pengguna</h2>

        <!-- Nama Pengguna -->
        <div style="margin-bottom: 15px;">
            <label for="name" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Nama Pengguna</label>
            <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Username -->
        <div style="margin-bottom: 15px;">
            <label for="username" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Username</label>
            <input type="text" id="username" class="form-control" value="{{ $user->username }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Email Pengguna -->
        <div style="margin-bottom: 15px;">
            <label for="email" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Email</label>
            <input type="email" id="email" class="form-control" value="{{ $user->email }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Role -->
        <div style="margin-bottom: 15px;">
            <label for="role" style="font-weight: bold; color: #1e3a8a; display: block; margin-bottom: 5px;">Role</label>
            <input type="text" id="role" class="form-control" value="{{ $roles[$user->id_role] ?? 'Unknown' }}" readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; background-color: #f9f9f9;">
        </div>

        <!-- Button Kembali -->
        <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
            <a href="{{ route('user.index') }}" 
               style="padding: 10px 20px; background-color: #1e3a8a; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; text-align: center; transition: background-color 0.3s ease;"
               onmouseover="this.style.backgroundColor='#3b82f6';" 
               onmouseout="this.style.backgroundColor='#1e3a8a';">Kembali</a>
        </div>
    </div>
</div>
@endsection
