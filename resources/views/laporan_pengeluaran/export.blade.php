<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengeluaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Laporan Pengeluaran</h3>
    <p><strong>Dari Tanggal:</strong> {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}</p>
    <p><strong>Sampai Tanggal:</strong> {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</p>
    <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>User</th>
                <th>Nama Pengeluaran</th>
                <th>Keterangan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluaran as $index => $transaksi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_pengeluaran)->format('d/m/Y') }}</td>
                <td>{{ $transaksi->user->name ?? 'Tidak Ada Data' }}</td>
                <td>{{ $transaksi->nama_pengeluaran }}</td>
                <td>{{ $transaksi->keterangan_pengeluaran }}</td>
                <td>Rp {{ number_format($transaksi->total_pengeluaran, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
