<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengeluaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Laporan Pengeluaran</h1>
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
            @foreach ($pengeluaran as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->user }}</td>
                <td>{{ $item->nama_pengeluaran }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ number_format($item->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
