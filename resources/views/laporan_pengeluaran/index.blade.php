@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Pengeluaran</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }

            .content {
                margin-left: 120px;
                padding: 20px;
                background-color: #DEEFFE;
                border-radius: 10px;
            }

            h1 {
                font-size: 28px;
                font-weight: bold;
                color: #1e3a8a;
                margin-bottom: 20px;
            }

            /* Filter Section */
            .filter-section {
                display: flex;
                gap: 10px;
                margin-bottom: 20px;
            }

            .filter-section input {
                padding: 10px;
                width: 200px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 14px;
            }

            .filter-section button {
                background-color: #3b82f6;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                font-size: 14px;
                cursor: pointer;
            }

            .filter-section button:hover {
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
            }

            th,
            td {
                padding: 15px;
                text-align: center;
                border: 1px solid #ddd;
            }

            th {
                background-color: #1e3a8a;
                color: #fff;
                font-weight: bold;
            }

            td {
                color: #000;
            }

            .empty-message {
                text-align: center;
                font-size: 14px;
                color: #555;
            }
        </style>
    </head>

    <body>
        <div class="content">
            <h1>Laporan Pengeluaran</h1>

            <!-- Filter Section -->
            <div class="filter-section">
                <form action="{{ route('laporan-pengeluaran.index') }}" method="GET" style="display: flex; gap: 10px;">
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                        placeholder="Tanggal Mulai">
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                        placeholder="Tanggal Akhir">
                    <button type="submit"><i class="fas fa-filter"></i> Filter</button>
                </form>
            </div>

            <!-- Data Table -->
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Nama Pengeluaran</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengeluaran as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->user->name ?? 'Tidak Ada Data' }}</td>
                            <td>{{ $item->nama_pengeluaran }}</td>
                            <td>{{ $item->tanggal_pengeluaran }}</td>
                            <td>Rp {{ number_format($item->total_pengeluaran, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-message">Tidak ada data pengeluaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Export Button -->
            <div class="mt-3">
                <a href="{{ route('laporan-pengeluaran.exportPDF', request()->all()) }}" class="btn btn-danger">Export
                    PDF</a>
            </div>
        </div>
    </body>

    </html>
@endsection
