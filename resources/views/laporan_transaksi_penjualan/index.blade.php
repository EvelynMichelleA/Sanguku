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
            transition: right 0.3s ease-in-out;
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

        .reset-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            cursor: pointer;
        }

        .reset-button:hover {
            background-color: #b31c1c;
        }

        .total-row {
            font-weight: bold;
            background-color: #f0f4ff;
            color: #1e3a8a;
        }
    </style>
</head>

<body>
    <div id="filter-sidebar">
        <h3>Filter</h3>
        <form action="{{ route('laporan-transaksi.index') }}" method="GET">
            <label for="tanggal_dari">Tanggal Dari</label>
            <input type="date" id="tanggal_dari" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
            <label for="tanggal_sampai">Tanggal Sampai</label>
            <input type="date" id="tanggal_sampai" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
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
            <button type="button" class="reset-button" onclick="window.location.href='{{ route('laporan-transaksi.index') }}'">Reset</button>
        </form>
    </div>

    <div class="content">
        <h1>Laporan Transaksi Penjualan</h1>

        <div class="button-container">
            <a href="{{ route('laporan-transaksi.exportPDF', request()->all()) }}" class="add-button">EXPORT</a>
            <a href="#" class="filter-button" id="filter-button"><i class="fas fa-filter"></i></a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Transaksi</th>
                    <th>Subtotal</th>
                    <th>Poin Digunakan</th>
                    <th>Total Biaya</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $index => $trans)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $trans->user->name }}</td>
                        <td>{{ $trans->pelanggan?->nama_pelanggan ?? 'Guest' }}</td>
                        <td>{{ $trans->tanggal_transaksi }}</td>
                        <td>Rp {{ number_format($trans->subtotal, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($trans->diskon, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($trans->total_biaya, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 20px; text-align: center; color: #ff4d4d; font-size: 16px;">
                            Tidak ada data transaksi penjualan ditemukan.
                        </td>
                    </tr>
                @endforelse

                @if ($transaksi->count())
                    <tr class="total-row">
                        <td colspan="4">Total</td>
                        <td>Rp {{ number_format($transaksi->sum('subtotal'), 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($transaksi->sum('diskon'), 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($transaksi->sum('total_biaya'), 0, ',', '.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <script>
        const filterButton = document.getElementById('filter-button');
        const filterSidebar = document.getElementById('filter-sidebar');

        filterButton.addEventListener('click', () => {
            filterSidebar.style.right = filterSidebar.style.right === '0px' ? '-300px' : '0px';
        });
    </script>
</body>

</html>
