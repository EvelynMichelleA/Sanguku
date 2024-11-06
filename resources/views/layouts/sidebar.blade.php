<div class="sidebar">
    <div class="sidebar-header">
        <h2>SANGUKU</h2>
    </div>
    <ul class="sidebar-menu">
        <li><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
        <li>
            @if (auth()->user()->role->nama_role === 'Owner' || auth()->user()->role->nama_role === 'Supervisor')
                <a href="/pengguna"><i class="fas fa-users"></i> Kelola Pengguna</a>
            @endif
        </li>
        <li><a href="/transaksi-penjualan"><i class="fas fa-exchange-alt"></i> Kelola Transaksi Penjualan</a></li>
        <li><a href="/pengeluaran"><i class="fas fa-wallet"></i> Kelola Pengeluaran</a></li>
        <li><a href="/menu" class="active"><i class="fas fa-utensils"></i> Kelola Menu</a></li>
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
