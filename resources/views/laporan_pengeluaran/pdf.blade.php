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
        <h2>Laporan Pengeluaran</h2>
        <h4>Periode: 
            {{ $start_date ? $start_date : 'Tidak Ditentukan' }} 
            sampai 
            {{ $end_date ? $end_date : 'Tidak Ditentukan' }}
        </h4>
        <h5>Tanggal Laporan: {{ now()->format('d-m-Y') }}</h5>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pengeluaran</th>
                <th>Nama Pengeluaran</th>
                <th>Keterangan</th>
                <th>Total Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse($pengeluaran as $index => $item)
                @php $grandTotal += $item->total_pengeluaran; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tanggal_pengeluaran }}</td>
                    <td>{{ $item->nama_pengeluaran }}</td>
                    <td>{{ $item->keterangan_pengeluaran }}</td>
                    <td>{{ 'Rp ' . number_format($item->total_pengeluaran, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data pengeluaran</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total Pengeluaran</td>
                <td>{{ 'Rp ' . number_format($grandTotal, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <footer>
        Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
    </footer>
</body>
</html>
