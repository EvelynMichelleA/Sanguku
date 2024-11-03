<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi Penjualan</title>
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

        .sidebar-menu a, .sidebar-menu form button {
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
        }

        .sidebar-menu a i, .sidebar-menu form button i {
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

    /* Button Container Styling */
    .button-container {
        display: flex;
        position: absolute;
        top: 20px;
        right: 20px;
        gap: 10px; /* Menambah jarak antar tombol */
    }

    .add-button {
        background-color: #3b82f6;
        color: #fff;
        padding: 8px 30px; /* Meningkatkan tinggi dan lebar */
        border-radius: 5px;
        text-decoration: none;
        font-size: 16px; /* Meningkatkan ukuran font */
    }

    .filter-button {
        background-color: #3b82f6;
        color: #fff;
        padding: 8px 20px; /* Meningkatkan tinggi dan lebar */
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px; /* Meningkatkan ukuran font */
    }

    .button-container a:hover {
        background-color: #1e3a8a;
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
            <li>
                <a href="/dashboard">
                    <i class="fas fa-home"></i> Beranda
                </a>
            </li>
            <li>
                @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                    <a href="/pengguna"><i class="fas fa-users"></i> Kelola Pengguna</a>
                @endif
            </li>
            <li>
                <a href="/transaksi-penjualan" class="active">
                    <i class="fas fa-exchange-alt"></i> Kelola Transaksi Penjualan
                </a>
            </li>
            <li>
                <a href="/pengeluaran">
                    <i class="fas fa-wallet"></i> Kelola Pengeluaran
                </a>
            </li>
            <li>
                <a href="/menu">
                    <i class="fas fa-utensils"></i> Kelola Menu
                </a>
            </li>
            <li>
                <a href="/pelanggan">
                    <i class="fas fa-user-friends"></i> Kelola Pelanggan
                </a>
            </li>
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
                <!-- Form Logout -->
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="display: flex; align-items: center; padding: 10px 20px; color: #ffffff; background: none; border: none; cursor: pointer; font-size: 17px; width: 100%; text-align: left;">
                        <i class="fas fa-power-off" style="margin-right: 10px;"></i> Logout
                    </button>
                </form>
            </li>            
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Transaksi Penjualan</h1>

        <div class="button-container">
            <a href="#" class="add-button">TAMBAH</a>
            <a href="#" class="filter-button"><i class="fas fa-filter"></i></a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Transaksi</th>
                    <th>Total Biaya</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $index => $trans)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $trans->pengguna->name }}</td>
                        <td>{{ $trans->pelanggan->nama_pelanggan }}</td>
                        <td>{{ $trans->tanggal_transaksi }}</td>
                        <td>Rp {{ number_format($trans->total_biaya, 0, ',', '.') }}</td>
                        <td class="action-icons">
                            <a href="/transaksi-penjualan/{{ $trans->id_transaksi_penjualan }}/edit"><i
                                    class="fas fa-edit"></i></a>
                            <a href="/transaksi-penjualan/{{ $trans->id_transaksi_penjualan }}"><i
                                    class="fas fa-eye"></i></a>
                            <a href="/transaksi-penjualan/{{ $trans->id_transaksi_penjualan }}/delete"><i
                                    class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
