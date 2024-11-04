<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            background-color: #2758A7;
        }

        .container {
            display: flex;
            width: 100%;
        }

        .left {
            flex: 0.7;
            background: url('/img/SangukuLogin.jpg') no-repeat center bottom;
            background-size: cover;
            position: relative;
        }

        .left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(39, 88, 167, 0.5);
            z-index: 1;
        }

        .sanguku-text-background {
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'Comic Sans MS', cursive, sans-serif;
            font-size: 5em;
            font-weight: bold;
            color: white;
            z-index: 2;
        }

        .info-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%);
            font-family: Arial, sans-serif;
            font-size: 1.5em;
            color: white;
            z-index: 2;
        }

        .right {
            flex: 0.5;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #FFFFFF;
        }

        .login-form {
            width: 80%;
            max-width: 400px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .login-form h1 {
            font-size: 2em;
            margin-bottom: 5px;
        }

        .login-form p {
            margin-bottom: 20px;
            color: #666;
        }

        .sanguku-text {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            font-size: 3.5em;
            font-weight: bold;
            color: #2758A7 !important;
            margin-bottom: 20px;
            margin-top: 0;
        }

        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 25px;
            box-sizing: border-box;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #2758A7;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #487FD7;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
            font-size: 0.9em;
            color: #666;
        }

        .forgot-password a {
            color: #666;
            text-decoration: none;
            font-weight: bold;
        }

        .forgot-password a:hover {
            color: #2f4f4f;
        }

        .remember-me {
            text-align: left;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            margin-top: 20px;
            font-size: 0.9em;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <div class="sanguku-text-background">SANGUKU</div>
            <div class="info-text">Sistem Informasi Sanguku Cafe</div>
        </div>
        <div class="right">
            <div class="login-form">
                <h1>WELCOME TO</h1>
                <p class="sanguku-text">SANGUKU</p>
                <p>Login to your account</p>

                <!-- Session Flash Messages -->
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('loginError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="/login" method="post">
                    @csrf
                    <div class="form-floating">
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Email" required value="{{ old('email') }}">
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Password" required>
                    </div>

                    <div class="remember-me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">Keep me logged in</label>
                    </div>

                    <div class="forgot-password">
                        Don't have an account? 
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    </div>

                    <button type="submit">Log in</button>

                    <!-- Pesan Kesalahan -->
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</body>

</html>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
