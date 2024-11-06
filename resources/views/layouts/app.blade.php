<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Sidebar Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #1e3a8a;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
        }

        .sidebar-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 30px;
        }

        .sidebar-header h2 {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            font-size: 30px;
            font-weight: bold;
            color: #ffffff;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 15px;
        }

        .sidebar-menu a,
        .sidebar-menu button {
            display: flex;
            align-items: center;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            background: none;
            border: none;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            width: 100%;
            text-align: left;
            box-sizing: border-box;
        }

        .sidebar-menu a i,
        .sidebar-menu form button i {
            margin-right: 10px;
        }

        .sidebar-menu a.active,
        .sidebar-menu a:hover,
        .sidebar-menu form button:hover {
            background-color: #3b82f6;
        }

        .sidebar-menu form button:hover {
            color: #ffffff;
            background-color: #3b82f6;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-blue-100">

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>SANGUKU</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                <li>
                    @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                        <a href="/pengguna"><i class="fas fa-users"></i> Kelola Pengguna</a>
                    @endif
                </li>
                <li><a href="/transaksi-penjualan"><i class="fas fa-exchange-alt"></i> Kelola Transaksi Penjualan</a></li>
                <li><a href="/pengeluaran"><i class="fas fa-wallet"></i> Kelola Pengeluaran</a></li>
                <li><a href="/menu" class="active"><i class="fas fa-utensils"></i> Kelola Menu</a></li>
                <li><a href="/pelanggan"><i class="fas fa-user-friends"></i> Kelola Pelanggan</a></li>
                <li>
                    @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                        <a href="/laporan-transaksi"><i class="fas fa-file-alt"></i> Laporan Transaksi Penjualan</a>
                    @endif
                </li>
                <li>
                    @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                        <a href="/laporan-pengeluaran"><i class="fas fa-file-invoice"></i> Laporan Pengeluaran</a>
                    @endif
                </li>
                <li>
                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-power-off"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
