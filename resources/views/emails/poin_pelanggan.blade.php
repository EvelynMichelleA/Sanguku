<!DOCTYPE html>
<html>
<head>
    <title>Informasi Poin Pelanggan</title>
</head>
<body>
    <h2>Halo, {{ $pelanggan->nama_pelanggan }}</h2>
    <p>Terima kasih telah melakukan transaksi. Berikut adalah informasi terkait poin Anda:</p>
    <ul>
        <li><strong>Poin Sebelumnya:</strong> {{ $poinSebelum }}</li>
        <li><strong>Poin Digunakan:</strong> {{ $poinDigunakan }}</li>
        <li><strong>Poin Dihasilkan:</strong> {{ $poinDihasilkan }}</li>
        <li><strong>Total Poin Saat Ini:</strong> {{ $pelanggan->jumlah_poin }}</li>
    </ul>
    <p>Semoga Anda menikmati layanan kami. Sampai jumpa lagi!</p>
</body>
</html>
