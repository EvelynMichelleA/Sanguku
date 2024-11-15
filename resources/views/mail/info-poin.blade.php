<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Poin Transaksi</title>
</head>
<body>
    <h3>Informasi Poin Pelanggan</h3>

    <p><strong>Nama Pelanggan:</strong> {{ $pelanggan->nama_pelanggan }}</p>

    <p><strong>Poin yang Digunakan:</strong> {{ number_format($diskon, 0, ',', '.') }} Poin</p>

    <p><strong>Poin Baru yang Diberikan:</strong> {{ number_format($poinBaru, 0, ',', '.') }} Poin</p>

    <p><strong>Sisa Poin:</strong> {{ number_format($pelanggan->jumlah_poin, 0, ',', '.') }} Poin</p>

    <p>Terima kasih telah bertransaksi dengan kami!</p>
</body>
</html>
