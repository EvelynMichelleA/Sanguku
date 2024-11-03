<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            background-image: url('/img/SangukuLogin.jpg'); /* Sesuaikan dengan path gambar latar belakang */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Layer transparan biru */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(39, 88, 167, 0.5); /* Biru dengan transparansi 30% */
            z-index: 1;
        }

        .form-card {
            position: relative;
            z-index: 2;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            width: 300px;
            text-align: center;
        }

        .form-card .user-icon {
            font-size: 60px;
            color: #333;
            margin-bottom: 20px;
        }

        .form-card h2 {
            font-size: 1.2em;
            color: #333;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .form-card input[type="email"],
        .form-card button {
            width: 100%;
            box-sizing: border-box;
        }

        .form-card input[type="email"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            margin-bottom: 20px;
            font-size: 1em;
            color: #333;
        }

        .form-card button {
            background-color: #000;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .form-card button:hover {
            background-color: #333;
        }

        .status-message {
            color: green;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Layer Transparan Biru -->
    <div class="overlay"></div>

    <div class="form-card">
        <div class="user-icon">&#128100;</div> <!-- Menggunakan simbol Unicode untuk ikon pengguna -->
        <h2>Masukkan Email Pengguna</h2>

        <!-- Session Flash Messages -->
        @if (session('status'))
            <div class="status-message">{{ session('status') }}</div>
        @endif

        <!-- Formulir Reset Password -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Input Email -->
            <div>
                <input id="email" type="email" name="email" placeholder="Email..." value="{{ old('email') }}" required autofocus>
                <!-- Pesan Error untuk Email -->
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <button type="submit">Dapatkan Kode Verifikasi</button>
        </form>
    </div>

</body>
</html>
