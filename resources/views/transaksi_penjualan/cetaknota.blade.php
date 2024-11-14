<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .nota {
            width: 80mm;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            font-weight: bold;
        }

        .header p {
            font-size: 12px;
            margin: 0;
            color: #555;
        }

        .info {
            margin-bottom: 20px;
            font-size: 12px;
        }

        .info p {
            margin: 5px 0;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px dashed #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .total {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="nota">
        <!-- Header Nota -->
        <div class="header">
            <h1>Toko Sanguku</h1>
            <p>Jl. Transaksi No. 123, Bandung</p>
            <p>Telp: 0812-3456-7890</p>
        </div>

        <!-- Informasi Transaksi -->
        <div class="info">
            <p><strong>Transaksi ID:</strong> {{ $transaksi->id_transaksi_penjualan }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}</p>
            <p><strong>User:</strong> {{ $transaksi->user->name }}</p>
            <p><strong>Nama Pelanggan:</strong> {{ $transaksi->pelanggan?->nama_pelanggan ?? 'Guest' }}</p>
        </div>

        <!-- Detail Transaksi -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->details as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->nama_menu }}</td>
                        <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Biaya -->
        <div class="total">
            <p>Total Biaya: Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima Kasih atas kunjungan Anda!</p>
            <p>Toko Sanguku</p>
        </div>
    </div>
</body>

</html>
