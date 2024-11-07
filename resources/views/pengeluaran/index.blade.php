<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengeluaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Styling Sidebar */
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
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            width: 100%;
            /* Menggunakan lebar penuh */
            text-align: left;
            box-sizing: border-box;
            /* Agar padding termasuk dalam lebar elemen */
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

        /* Styling Content */
        .content {
            margin-left: 270px;
            padding: 20px;
            position: relative;
            background-color: #DEEFFE;
        }

        .content h1 {
            font-size: 28px;
            font-weight: bold;
            color: #1e3a8a;
            display: inline-block;
        }

        .add-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #3b82f6;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        /* Filter Section */
        .filter-section input[type="text"] {
            padding: 12px;
            width: 150px;
            border: 1px solid #000000; /* Outline lebih tipis */
            border-radius: 15px;
            font-size: 16px;
            text-align: center;
            margin-right: 10px;
            box-sizing: border-box;
        }

        .filter-section button {
            background-color: #3b82f6;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
            border: 5px solid #3b82f6;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #1e3a8a;
            color: #fff;
            text-align: center;
        }

        td {
            text-align: center;
        }

        .action-icons a {
            color: #1e3a8a;
            margin: 0 5px;
            font-size: 18px;
            text-decoration: none;
        }

        .action-icons a:hover {
            color: #3b82f6;
        }
    </style>
</head>

<body>
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
            <li><a href="/pengeluaran" class="active"><i class="fas fa-wallet"></i> Kelola Pengeluaran</a></li>
            <li><a href="/menu"><i class="fas fa-utensils"></i> Kelola Menu</a></li>
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

    <!-- Content -->
    <div class="content">
        <h1>Pengeluaran</h1>
        <a href="{{ route('pengeluaran.create') }}" class="add-button">TAMBAH</a>

        <!-- Filter Section -->
        <div class="filter-section">
            <div>
                <input type="text" placeholder="DD/MM/YYYY">
                <input type="text" placeholder="DD/MM/YYYY">
                <button><i class="fas fa-filter" style="color: white;"></i> Filter</button>
            </div>
        </div>

        <!-- Pengeluaran Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengeluaran</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengeluaran as $item)
                    <tr>
                        <td>{{ $item->id_pengeluaran }}</td>
                        <td>{{ $item->nama_pengeluaran }}</td>
                        <td>Rp {{ number_format($item->total_pengeluaran, 0, ',', '.') }}</td>
                        <td>{{ $item->tanggal_pengeluaran }}</td>
                        <td class="action-icons">
                            <a href="{{ route('pengeluaran.show', $item->id_pengeluaran) }}" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/pengeluaran/{{ $item->id_pengeluaran }}/delete"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
