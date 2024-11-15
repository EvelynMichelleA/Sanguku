@extends('layouts.app')

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

        .button-container {
            display: flex;
            position: absolute;
            top: 20px;
            right: 20px;
            gap: 10px;
        }

        .add-button {
            background-color: #3b82f6;
            color: #fff;
            padding: 8px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .filter-button {
            background-color: #3b82f6;
            color: #fff;
            padding: 8px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .button-container a:hover {
            background-color: #1e3a8a;
        }

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

        /* Sidebar Filter Styling */
        #filter-sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background-color: #ffffff;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            overflow-y: auto;
            transition: right 0.3s ease;
            z-index: 1000;
        }

        #filter-sidebar h3 {
            font-size: 20px;
            color: #1e3a8a;
            font-weight: bold;
            margin-bottom: 20px;
        }

        #filter-sidebar label {
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 5px;
            display: block;
        }

        #filter-sidebar input,
        #filter-sidebar select,
        #filter-sidebar button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        #filter-sidebar button {
            background-color: #3b82f6;
            color: white;
            border: none;
            cursor: pointer;
        }

        #filter-sidebar button:hover {
            background-color: #1e3a8a;
        }
    </style>
</head>

<body>
    <!-- Filter Sidebar -->
    <div id="filter-sidebar">
        <h3>Filter</h3>
        <form action="{{ route('transaksi-penjualan.index') }}" method="GET">
            <!-- Filter Tanggal Dari -->
            <label for="tanggal_dari">Tanggal Dari</label>
            <input type="date" id="tanggal_dari" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
            <!-- Filter Tanggal Sampai -->
            <label for="tanggal_sampai">Tanggal Sampai</label>
            <input type="date" id="tanggal_sampai" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
            <!-- Filter Nama Pelanggan -->
            <label for="nama_pelanggan">Nama Pelanggan</label>
            <select id="nama_pelanggan" name="nama_pelanggan">
                <option value="">Semua Pelanggan</option>
                @foreach ($pelanggan as $p)
                    <option value="{{ $p->nama_pelanggan }}"
                        {{ request('nama_pelanggan') == $p->nama_pelanggan ? 'selected' : '' }}>
                        {{ $p->nama_pelanggan }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Terapkan</button>
        </form>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Transaksi Penjualan</h1>

        <div class="button-container">
            <a href="{{ route('transaksi-penjualan.create') }}" class="add-button">TAMBAH</a>
            <a href="#" class="filter-button" id="filter-button"><i class="fas fa-filter"></i></a>
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
                @forelse ($transaksi as $index => $trans)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $trans->user->name }}</td>
                        <td>{{ $trans->pelanggan?->nama_pelanggan ?? 'Guest' }}</td> <!-- Perbaikan di sini -->
                        <td>{{ $trans->tanggal_transaksi }}</td>
                        <td>Rp {{ number_format($trans->total_biaya, 0, ',', '.') }}</td>
                        <td class="action-icons">
                            <a href="{{ route('transaksi-penjualan.show', $trans->id_transaksi_penjualan) }}"
                                class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                                <a href="{{ route('transaksi-penjualan.cetak', $trans->id_transaksi_penjualan) }}">
                                    <i class="fas fa-print"></i>
                                </a>
                                <form action="{{ route('transaksi-penjualan.sendEmail', $trans->id_transaksi_penjualan) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm"
                                        style="padding: 5px 10px; border-radius: 5px; background-color: #ffcc00; color: #333;">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 20px; text-align: center; color: #1e3a8a; font-size: 16px;">
                            Tidak ada data transaksi penjualan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>
        // JavaScript untuk membuka dan menutup sidebar filter
        const filterButton = document.getElementById('filter-button');
        const filterSidebar = document.getElementById('filter-sidebar');

        filterButton.addEventListener('click', () => {
            if (filterSidebar.style.right === '0px') {
                filterSidebar.style.right = '-300px';
            } else {
                filterSidebar.style.right = '0px';
            }
        });
    </script>
</body>

</html>
