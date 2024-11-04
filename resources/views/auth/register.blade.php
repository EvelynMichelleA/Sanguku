<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SANGUKU</title>
    <style>
        /* Latar belakang halaman */
        body {
            background-image: url('/img/SangukuLogin.jpg');
            /* Sesuaikan dengan path gambar latar belakang */
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
            background-color: rgba(39, 88, 167, 0.5);
            /* Biru dengan transparansi 50% */
            z-index: 1;
        }

        /* Kontainer utama form */
        .register-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px 30px;
            /* Mengurangi padding atas/bawah untuk membuatnya lebih pendek */
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            /* Menambah lebar maksimum kotak */
            text-align: center;
            z-index: 2;
            /* Pastikan form berada di atas overlay */
            position: relative;
        }

        /* Gaya untuk ikon */
        .register-container .icon {
            font-size: 50px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Gaya heading */
        .register-container h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        /* Gaya label */
        .register-container label {
            display: block;
            font-weight: bold;
            color: #333;
            text-align: left;
            margin-bottom: 5px;
        }

        /* Gaya input */
        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: none;
            border-radius: 25px;
            background: #f0f4f8;
            font-size: 16px;
            color: #333;
            box-sizing: border-box;
        }

        /* Gaya tombol */
        .register-container .register-btn {
            width: 100%;
            padding: 12px;
            background-color: #3b82f6;
            color: #fff;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
        }

        /* Hover pada tombol */
        .register-container .register-btn:hover {
            background-color: #1e3a8a;
        }

        /* Link Already Registered */
        .register-container .already-registered {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
            text-decoration: none;
        }

        .register-container .already-registered:hover {
            color: #333;
        }

        /* Gaya error message */
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            text-align: left;
        }
    </style>
</head>

<body>
    <!-- Layer transparan biru -->
    <div class="overlay"></div>

    <!-- Kontainer form pendaftaran -->
    <div class="register-container">
        <h2>Register</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Name -->
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Name" required value="{{ old('name') }}">
            @if ($errors->has('name'))
                <div class="error-message">{{ $errors->first('name') }}</div>
            @endif

            <!-- Username -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" required
                value="{{ old('username') }}">
            @if ($errors->has('username'))
                <div class="error-message">{{ $errors->first('username') }}</div>
            @endif

            <!-- Email -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required
                value="{{ old('email') }}">
            @if ($errors->has('email'))
                <div class="error-message">{{ $errors->first('email') }}</div>
            @endif

            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            @if ($errors->has('password'))
                <div class="error-message">{{ $errors->first('password') }}</div>
            @endif

            <!-- Confirm Password -->
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                placeholder="Confirm Password" required>
            @if ($errors->has('password_confirmation'))
                <div class="error-message">{{ $errors->first('password_confirmation') }}</div>
            @endif

            <!-- Role (Hidden) -->
            <input type="hidden" name="id_role" value="1"> <!-- Set default role -->

            <!-- Register Button -->
            <button type="submit" class="register-btn">REGISTER</button>

            <!-- Already Registered Link -->
            <a href="{{ route('login') }}" class="already-registered">Already registered?</a>
        </form>
    </div>
</body>

</html>
