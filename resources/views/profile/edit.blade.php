<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-900 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <style>
        /* Background utama */
        body {
            background-color: #f0f4f8;
        }

        /* Style untuk input agar kontras dengan background */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea {
            background-color: #e6f0ff !important; /* Biru muda */
            color: #1e3a8a; /* Teks biru tua */
            border: 1px solid #cbd5e0; /* Border abu terang */
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        /* Style saat input dalam focus */
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        textarea:focus {
            border-color: #3b82f6; /* Biru lebih cerah saat focus */
            outline: none;
        }

        /* Warna teks header dan instruksi */
        h3 {
            color: #1e3a8a;
            font-weight: bold;
            font-size: 1.2rem;
        }

        p {
            color: #4a5568; /* Abu-abu tua untuk teks instruksi */
        }

        /* Tombol save yang lebih kontras */
        .btn-save {
            background-color: #3b82f6;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-transform: uppercase;
        }

        .btn-save:hover {
            background-color: #1e3a8a; /* Biru tua saat hover */
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Update Profile Information -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
