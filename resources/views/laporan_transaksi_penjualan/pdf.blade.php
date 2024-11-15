<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengeluaran</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header h2, header h4 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        footer {
            text-align: right;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h2>Laporan Transaksi</h2>
        <h4>Nama User: {{ $user->name }}</h4>
        <h4>Nama Pelanggan: {{ $pelanggan->nama_pelanggan }}</h4>
        <h5>Tanggal Transaksi: {{ $transaksi->tanggal_transaksi->format('d-m-Y') }}</h5>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Menu</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $totalBiaya = 0; @endphp
            @foreach($transaksi->details as $index => $detail)
                @php $totalBiaya += $detail->subtotal; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->nama_menu }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total Biaya</td>
                <td>{{ number_format($totalBiaya, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;">Jumlah Poin Digunakan</td>
                <td>{{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total Setelah Diskon</td>
                <td>{{ number_format($totalBiaya - $transaksi->diskon, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <footer>
        Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
    </footer>
</body>
</html>
