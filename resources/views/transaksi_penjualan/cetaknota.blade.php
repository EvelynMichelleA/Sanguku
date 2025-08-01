<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        /* Mengatur ukuran kertas Nota untuk pencetakan */
        @page {
            size: 90mm 297mm;
            /* Ukuran standar nota */
            margin: 0;
            /* Menghilangkan margin untuk ukuran penuh */
        }

        /* Reset margin dan padding untuk body dan html */
        body,
        html {
            margin: 0;
            padding: 0;
            width: 90mm;
            /* Ukuran kertas */
            height: 297mm;
            /* Ukuran kertas */
        }

        /* Styling untuk Nota */
        .nota {
            width: 80mm;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
        }

        .header p {
            font-size: 10px;
            margin: 0;
            color: #555;
        }

        .info {
            margin-bottom: 15px;
            font-size: 10px;
        }

        .info p {
            margin: 5px 0;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table th,
        table td {
            border: 1px dashed #ddd;
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }

        table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }


        .subtotal {
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }
       

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 8px;
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
        <div class="subtotal">
            <p>Subtotal: Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</p>
            <p>Diskon: Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</p>
            <p>Total Biaya: Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</p>
            <p>Jumlah Bayar: Rp {{ number_format($transaksi->jumlah_uang, 0, ',', '.') }}</p>
            <p>Kembalian: Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>

        <!-- Footer -->
        <div class="footer">
            <p>Terima Kasih atas kunjungan Anda!</p>
            <p>Toko Sanguku</p>
        </div>
    </div>
</body>

</html>
