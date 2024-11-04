@php
    use App\Models\Pelanggan;
    use App\Models\TransaksiPenjualan;

    // Mengambil data secara langsung di Blade
    $jumlahPelanggan = Pelanggan::count();
    $jumlahTransaksi = TransaksiPenjualan::count();
    $totalPendapatan = TransaksiPenjualan::sum('total_biaya'); // Sesuaikan dengan kolom pendapatan
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SANGUKU</title>

    <!-- Link Google Fonts untuk Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Terapkan font Poppins ke seluruh halaman */
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Styling Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #1e3a8a;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar-header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            font-family: 'Comic Sans MS';
            color: #ffffff;
            margin-bottom: 30px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 15px;
        }

        .sidebar-menu a,
        .sidebar-menu button {
            display: flex;
            align-items: center;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            background: none;
            border: none;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            width: 100%;
            text-align: left;
            box-sizing: border-box;
        }

        .sidebar-menu a i,
        .sidebar-menu form button i {
            margin-right: 10px;
        }

        .sidebar-menu a.active,
        .sidebar-menu a:hover,
        .sidebar-menu form button:hover {
            background-color: #3b82f6;
        }

        /* Styling Content */
        .content {
            margin-left: 270px;
            padding: 20px;
            background-color: #DEEFFE;
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

        /* Profile dropdown */
        .profile-menu {
            position: relative;
            display: inline-block;
        }

        .profile-button {
            color: #3b82f6;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .profile-button:hover {
        color: #1e3a8a; /* Biru tua */
    }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #3b82f6;
            color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px #3b82f6(0, 0, 0, 0.1);
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

        .card-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .card {
            flex: 1;
            min-width: 200px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            background-color: #3b82f6;
            color: #fff;
            padding: 12px;
            border-radius: 50%;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .card-content h3 {
            font-size: 18px;
            margin: 0;
            color: #666;
        }

        .card-content p {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #1e3a8a;
        }

        .chart-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 10px;
            margin-left: 20px;
        }

        .chart-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <div class="sidebar-header">
                <h2>SANGUKU</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="/dashboard" class="active"><i class="fas fa-home"></i> Beranda</a></li>
                <li>
                    @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                        <a href="/pengguna"><i class="fas fa-users"></i> Kelola Pengguna</a>
                    @endif
                </li>
                <li><a href="/transaksi-penjualan"><i class="fas fa-exchange-alt"></i> Kelola Transaksi<br>Penjualan</a>
                </li>
                <li><a href="/pengeluaran"><i class="fas fa-wallet"></i> Kelola Pengeluaran</a></li>
                <li><a href="/menu"><i class="fas fa-utensils"></i> Kelola Menu</a></li>
                <li><a href="/pelanggan"><i class="fas fa-user-friends"></i> Kelola Pelanggan</a></li>
                <li>
                    @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                        <a href="/laporan-transaksi"><i class="fas fa-file-alt"></i> Laporan Transaksi Penjualan</a>
                    @endif
                </li>
                <li>
                    @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                        <a href="/laporan-pengeluaran"><i class="fas fa-file-invoice"></i> Laporan Pengeluaran</a>
                    @endif
                </li>
                <li>
                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-power-off"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="header">
            Dashboard
            <!-- Profile Dropdown -->
            <div class="profile-menu">
                <div class="profile-button" onclick="toggleDropdown()">
                    {{ auth()->user()->name }} <i class="fas fa-caret-down" style="margin-left: 5px;"></i>
                </div>
                <div class="dropdown-menu" id="profileDropdown">
                    <a href="{{ route('profile.edit') }}">Profile Edit</a>
                </div>
            </div>
        </div>

        <!-- Card Container -->
        <div class="card-container">
            <div class="card">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <div class="card-content">
                    <h3>Pelanggan</h3>
                    <p>{{ $jumlahPelanggan }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-clipboard-list"></i></div>
                <div class="card-content">
                    <h3>Pendapatan</h3>
                    <p>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="card-content">
                    <h3>Transaksi</h3>
                    <p>{{ $jumlahTransaksi }}</p>
                </div>
            </div>
        </div>

        <!-- Judul Grafik Penjualan Bulanan -->
        <div class="chart-title">Penjualan Tahun Ini</div>

        <!-- Grafik Penjualan Bulanan -->
        <div class="chart-container">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Script Chart.js dan Toggle Dropdown -->
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ],
                datasets: [{
                    label: 'Total Pendapatan (Rp)',
                    data: @json($dataPenjualan), // Data dari route
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
                },
                plugins: {
                    legend: {
                        display: false
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
