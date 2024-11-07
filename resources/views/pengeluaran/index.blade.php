@extends('layouts.app');
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
