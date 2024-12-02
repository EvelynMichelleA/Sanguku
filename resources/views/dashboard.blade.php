@php
    use Carbon\Carbon;
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
            font-size: 28px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 20px;
            /* display: flex;
            justify-content: space-between; */
            align-items: center;
            padding: 8px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background-color: #fff;
            margin-bottom: 20px;
            width: 150px;
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
            background-color: #;
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
            justify-content: center;
        }

        .balance-card h3 {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 30px;
            margin-right: 160px;
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
            flex: 1;
            width: 69%;
            margin-top: 30px;
        }

        .contents {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            /* Menjaga elemen-elemen responsif */
        }

        .chart-container table th,
        .chart-container table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .chart-container table th {
            background-color: #f0f4f8;
        }

        .chart-container table tbody tr {
            /* Menambahkan jarak antara baris */
            margin-bottom: 10px;
        }

        .chart-container table tbody tr:hover {
            background-color: #f0f4f8;
        }

        /* Menambahkan lebih banyak padding untuk membuat jarak antara baris lebih besar */
        .chart-container table td {
            padding: 20px;
            /* Menambah padding agar baris tabel lebih renggang */
        }

        /* Profile dropdown */
        .profile-menu {
            position: relative;
            display: inline-block;
        }

        .profile-button {
            color: #1e3a8a;
            /* Warna sama dengan Dashboard */
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .profile-button:hover {
            color: #3b82f6;
            /* Warna biru saat hover */
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #3b82f6;
            color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-width: 120px;
            padding: 10px 0;
            z-index: 1000;
        }

        .dropdown-menu a {
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            font-size: 14px;
        }

        .dropdown-menu a:hover {
            background-color: #80a4ff;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="header">
            <span>Dashboard</span>
            <div class="profile-menu">
                <div class="profile-button" onclick="toggleDropdown()">
                    {{ auth()->user()->name }} <i class="fas fa-caret-down" style="margin-left: 5px;"></i>
                </div>
                <div class="dropdown-menu" id="profileDropdown">
                    <a href="{{ route('profile.edit') }}">Profile Edit</a>
                </div>
            </div>
        </div>
        <form method="GET" action="{{ route('dashboard') }}">
            <select name="tahun" id="tahun" onchange="this.form.submit()">
                <option value="">Pilih Tahun</option>
                @foreach (range(2020, Carbon::now()->year) as $year)
                    <option value="{{ $year }}" {{ $year == ($tahunDipilih ?? '') ? 'selected' : '' }}>
                        {{ $year }}</option>
                @endforeach
            </select>
        </form>

        <!-- Widget Containers -->
        <div class="widget-container">
            <div class="widget-card">
                <div>
                    <a href="{{ route('pelanggan.index') }}">
                        <h3>Pelanggan</h3>
                        <p>{{ $jumlahPelanggan }}</p>
                    </a>
                </div>
                <div><i class="fas fa-users icon"></i></div>
            </div>
            <div class="widget-card">
                <div>
                    <a href="{{ route('menu.index') }}">
                        <h3>Total Menu</h3>
                        <p>{{ $jumlahMenu }}</p>
                    </a>
                </div>
                <div><i class="fas fa-utensils icon"></i></div>
            </div>
            <div class="widget-card">
                <div>
                    <a href="{{ route('transaksi-penjualan.index') }}">
                        <h3>Total Pendapatan</h3>
                        <p>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </a>
                </div>
                <div><i class="fas fa-dollar-sign icon"></i></div>
            </div>
        </div>

        <!-- Grafik Penjualan Bulanan -->
        <div class="contents">
            <div class="chart-container">
                <div class="chart-title">Penjualan</div>
                <canvas id="salesChart"></canvas>
            </div>

            <div class="balance-card">
                <div>
                    <h3>Balance (Profit / Loss)</h3>
                    <canvas id="balanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Pengeluaran dan Menu Terlaris -->
        <div class="contents">
            <div class="chart-container">
                <div class="chart-title">Pengeluaran</div>
                <canvas id="pengeluaranChart"></canvas>
            </div>

            <div class="chart-container">
                <div class="chart-title">Menu Terlaris</div>
                <table class="table-auto w-full text-sm text-left text-gray-500">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 bg-gray-200">No</th>
                            <th class="px-4 py-2 bg-gray-200">Menu</th>
                            <th class="px-4 py-2 bg-gray-200">Jumlah Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menuNames as $index => $menu)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $menu }}</td>
                                <td class="px-4 py-2">{{ $menuSales[$index] }} pcs</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- JavaScript for Charts -->
    <script>
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
                    backgroundColor: ['#3b82f6', '#F87171'],
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

        // Chart.js for Menu Terlaris
        var ctx2 = document.getElementById('menuChart').getContext('2d');
        var menuChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Menu 1', 'Menu 2', 'Menu 3'], // Nama menu terlaris
                datasets: [{
                    label: 'Menu Terlaris',
                    data: [50, 75, 90], // Update sesuai data
                    backgroundColor: '#4ade80',
                    borderColor: '#4ade80',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' : 'none';
        }

        window.onclick = function(event) {
            if (!event.target.closest('.profile-menu')) {
                const dropdown = document.getElementById('profileDropdown');
                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                }
            }
        };
    </script>
</body>

</html>
