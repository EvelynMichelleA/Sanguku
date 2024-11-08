<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Sidebar Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Gunakan Poppins untuk semua elemen kecuali SANGUKU */
            background-color: #cbe6fe;
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
            margin-bottom: 30px;
        }
    
        .sidebar-header h2 {
            font-family: 'Comic Sans MS', cursive, sans-serif; /* Font untuk SANGUKU */
            font-size: 36px; /* Ukuran diperbesar */
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
            font-family: 'Poppins', sans-serif; /* Font Poppins untuk menu lainnya */
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
                <li>
                    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>
                <li>
                    @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                        <a href="/pengguna" class="{{ request()->is('pengguna') ? 'active' : '' }}"><i
                                class="fas fa-users"></i> Kelola Pengguna</a>
                    @endif
                </li>
                <li><a href="/pelanggan" class="{{ request()->is('pelanggan') ? 'active' : '' }}"><i
                            class="fas fa-user-friends"></i> Kelola Pelanggan</a></li>
                <li><a href="/menu" class="{{ request()->is('menu') ? 'active' : '' }}"><i
                            class="fas fa-utensils"></i> Kelola Menu</a></li>
                <li><a href="/transaksi-penjualan" class="{{ request()->is('transaksi-penjualan') ? 'active' : '' }}"><i
                            class="fas fa-exchange-alt"></i> Kelola Transaksi Penjualan</a></li>
                <li><a href="/pengeluaran" class="{{ request()->is('pengeluaran') ? 'active' : '' }}"><i
                            class="fas fa-wallet"></i> Kelola Pengeluaran</a></li>
                <li>
                    @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                        <a href="/laporan-transaksi" class="{{ request()->is('laporan-transaksi') ? 'active' : '' }}"><i
                                class="fas fa-file-alt"></i> Laporan Transaksi Penjualan</a>
                    @endif
                </li>
                <li>
                    @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                        <a href="/laporan-pengeluaran" class="{{ request()->is('laporan-pengeluaran') ? 'active' : '' }}"><i
                                class="fas fa-file-invoice"></i> Laporan Pengeluaran</a>
                    @endif
                </li>
            </ul>
            <div style="position: absolute; bottom: 20px; width: 100%; text-align: center;">
                <form action="{{ route('logout') }}" method="POST" style="width: 100%; padding: 0 20px;">
                    @csrf
                    <button type="submit" class="{{ request()->is('logout') ? 'active' : '' }}" style="width: 100%; display: flex; align-items: center;  background: none; color: #ffffff; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-family: 'Nunito', sans-serif;">
                        <i class="fas fa-power-off" style="margin-right: 10px;"></i> Logout
                    </button>
                </form>
            </div>
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
