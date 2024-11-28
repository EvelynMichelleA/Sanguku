@php
    use App\Models\Pelanggan;
    use App\Models\TransaksiPenjualan;
    use App\Models\Pengeluaran;
    use Carbon\Carbon;

    // Ambil data untuk dashboard
    $jumlahPelanggan = Pelanggan::count();
    $jumlahTransaksi = TransaksiPenjualan::count();
    $totalPendapatan = TransaksiPenjualan::sum('total_biaya');
    $totalPengeluaran = TransaksiPenjualan::sum('total_pengeluaran');
    $bulanIniPendapatan = TransaksiPenjualan::whereMonth('tanggal_transaksi', Carbon::now()->month)->sum('total_biaya');
    $tahunIniPendapatan = TransaksiPenjualan::whereYear('tanggal_transaksi', Carbon::now()->year)->sum('total_biaya');

    // Menghitung total pengeluaran
    $totalPengeluaran = Pengeluaran::sum('total_pengeluaran');
    $bulanIniPengeluaran = Pengeluaran::whereMonth('tanggal_pengeluaran', Carbon::now()->month)->sum(
        'total_pengeluaran',
    );
    $tahunIniPengeluaran = Pengeluaran::whereYear('tanggal_pengeluaran', Carbon::now()->year)->sum(
        'total_pengeluaran',
    );

    // Menghitung balance (profit/loss)
    $balance = $totalPendapatan - $totalPengeluaran;
    $profit = $balance >= 0 ? $balance : 0; // Profit
    $loss = $balance < 0 ? abs($balance) : 0; // Loss
@endphp

@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SANGUKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }

        .header {
            font-size: 28px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .filter-container select,
        .filter-container input {
            padding: 8px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        button {
            padding: 8px 15px;
            background-color: #3b82f6;
            color: white;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        .widget-container {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .widget-card {
            flex: 1;
            min-width: 230px;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .widget-card h3 {
            font-size: 16px;
            color: #666;
        }

        .widget-card p {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .widget-card .icon {
            font-size: 40px;
            color: #3b82f6;
        }

        .balance-card {
            flex: 1;
            min-width: 230px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            width: 31%;
            /* Menambahkan tinggi tetap pada balance card */
        }

        .balance-card h3 {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 100px;
        }

        .chart-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        .chart-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 69%;
            margin-top: 30px;
        }

        .contents {
            display: flex;
            /* Flexbox untuk menempatkan chart bersebelahan */
            justify-content: space-between;
            gap: 20px;
            /* Memberikan jarak antara kedua chart */
            flex-wrap: wrap;
            /* Menjaga responsivitas */
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="header">
            <span>Dashboard</span>
            <div class="filter-container">
                <form method="GET" action="{{ route('dashboard') }}">
                    <select name="bulan" id="bulan">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" @if (request('bulan') == $month) selected @endif>
                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                        @endforeach
                    </select>

                    <select name="tahun" id="tahun">
                        <option value="">-- Pilih Tahun --</option>
                        @foreach (range(2020, Carbon::now()->year) as $year)
                            <option value="{{ $year }}" @if (request('tahun') == $year) selected @endif>
                                {{ $year }}</option>
                        @endforeach
                    </select>

                    <button type="submit">Filter</button>
                </form>
            </div>
        </div>

        <!-- Widget Containers -->
        <div class="widget-container">
            <div class="widget-card">
                <div>
                    <h3>Pelanggan</h3>
                    <p>{{ $jumlahPelanggan }}</p>
                </div>
                <div><i class="fas fa-users icon"></i></div>
            </div>
            <div class="widget-card">
                <div>
                    <h3>Pendapatan Bulan Ini</h3>
                    <p>Rp {{ number_format($bulanIniPendapatan, 0, ',', '.') }}</p>
                </div>
                <div><i class="fas fa-wallet icon"></i></div>
            </div>
            <div class="widget-card">
                <div>
                    <h3>Total Pendapatan</h3>
                    <p>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
                <div><i class="fas fa-dollar-sign icon"></i></div>
            </div>

        </div>

        <!-- Grafik Penjualan Bulanan -->
        <div class="contents">
            <!-- Grafik Penjualan Bulanan -->
            <div class="chart-container">
                <div class="chart-title">Penjualan Bulan Ini</div>
                <canvas id="salesChart"></canvas>
                <!-- Menambahkan height untuk membuat grafik lebih pendek -->
            </div>

            <!-- Balance (Profit / Loss) -->
            <div class="balance-card">
                <div>
                    <h3>Balance (Profit / Loss)</h3>
                    <canvas id="balanceChart" height="50"></canvas> <!-- Menambahkan height untuk donut chart -->
                </div>
            </div>
        </div>
        <div class="chart-container">
            <div class="chart-title">Pengeluaran Bulan Ini</div>
            <canvas id="pengeluaranChart"></canvas>
            <!-- Menambahkan height untuk membuat grafik lebih pendek -->
        </div>

        <script>
            const ctxSales = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctxSales, {
                type: 'bar',
                data: {
                    labels: [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ],
                    datasets: [{
                        label: 'Pendapatan Bulanan (Rp)',
                        data: @json($dataPenjualan), // Data pendapatan dari controller
                        backgroundColor: '#3b82f6',
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
            const ctxPengeluaran = document.getElementById('pengeluaranChart').getContext('2d');
            const pengeluaranChart = new Chart(ctxPengeluaran, {
                type: 'bar',
                data: {
                    labels: [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ],
                    datasets: [{
                        label: 'Pengeluaran Bulanan (Rp)',
                        data: @json($dataPengeluaran), // Data pendapatan dari controller
                        backgroundColor: '#3b82f6',
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            const ctxBalance = document.getElementById('balanceChart').getContext('2d');
            const balanceChart = new Chart(ctxBalance, {
                type: 'doughnut',
                data: {
                    labels: ['Profit', 'Loss'],
                    datasets: [{
                        data: [{{ $profit }}, {{ $loss }}],
                        backgroundColor: ['#34D399', '#F87171'],
                        borderColor: ['#fff', '#fff'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Rp ' + tooltipItem.raw.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        </script>
</body>

</html>
