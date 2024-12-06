<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Poin Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: #3b82f6;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 1.5em;
            font-weight: bold; /* Membuat judul bold */
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 10px 0;
        }
        .content p strong {
            color: #3b82f6;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background: #f4f4f9;
            color: #777;
            font-size: 0.9em;
        }
        .footer a {
            color: #3b82f6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <strong>Informasi Poin Pelanggan</strong>
        </div>
        <div class="content">
            <p><strong>Nama Pelanggan:</strong> {{ $pelanggan->nama_pelanggan }}</p>

            <p><strong>Poin yang Digunakan:</strong> {{ number_format($diskon, 0, ',', '.') }} Poin</p>

            <p><strong>Poin Baru yang Diberikan:</strong> {{ number_format($poinBaru, 0, ',', '.') }} Poin</p>

            <p><strong>Sisa Poin:</strong> {{ number_format($pelanggan->jumlah_poin, 0, ',', '.') }} Poin</p>

            <p style="margin-top: 20px;">Terima kasih telah bertransaksi dengan kami!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sanguku Cafe. Semua Hak Dilindungi.</p>
            <p><a>Hubungi Kami:08983784927</a> | <a>Kebijakan Privasi</a></p>
        </div>
    </div>
</body>
</html>
