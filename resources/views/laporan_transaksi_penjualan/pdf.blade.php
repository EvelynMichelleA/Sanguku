<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
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
        {{-- <h4>Periode: 
            {{ $tanggalDari ? \Carbon\Carbon::parse($tanggalDari)->format('d-m-Y') : 'Tidak Ditentukan' }} 
            sampai 
            {{ $tanggalSampai ? \Carbon\Carbon::parse($tanggalSampai)->format('d-m-Y') : 'Tidak Ditentukan' }}
        </h4> --}}
        <h5>Tanggal Laporan: {{ now()->format('d-m-Y') }}</h5>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Nama User</th>
                <th>Nama Pelanggan</th>
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; $grandSubtotal=0;$grandDiskon=0; @endphp
            @forelse($transaksi as $index => $item)
                @php $grandTotal += $item->total_biaya; $grandSubtotal += $item->subtotal; $grandDiskon += $item->diskon; @endphp
                
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tanggal_transaksi }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->pelanggan ? $item->pelanggan->nama_pelanggan : 'Guest' }}</td>
                    <td>{{ 'Rp ' . number_format($item->subtotal, 2, ',', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($item->diskon, 2, ',', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($item->total_biaya, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data transaksi</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="6" style="text-align: right;">Total Sebelum Diskon</td>
                <td>{{ 'Rp ' . number_format($grandSubtotal, 2, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="6" style="text-align: right;">Total Diskon</td>
                <td>{{ 'Rp ' . number_format($grandDiskon, 2, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="6" style="text-align: right;">Total Pemasukan</td>
                <td>{{ 'Rp ' . number_format($grandTotal, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <footer>
        Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
    </footer>
</body>
</html>
