@extends('layouts.app')

@section('content')
<div class="card mt-4" style="background-color: rgba(246, 244, 219, 1);">
    <div class="card-header" style="background-color: rgba(90, 59, 41, 0.5); color: black;">
        <h2><i class="fas fa-plus-circle me-2"></i> Tambah Transaksi Penjualan</h2>
    </div>
    <div class="card-body">
        {{-- Form untuk menambahkan menu ke keranjang --}}
        <form action="{{ route('transaksi-penjualan.addToCart') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id_menu" class="form-label">Pilih Menu</label>
                    <select id="id_menu" name="id_menu" class="form-select" required>
                        <option value="" selected disabled>Pilih Menu</option>
                        @foreach ($menu as $item)
                            <option value="{{ $item->id_menu }}">
                                {{ $item->nama_menu }} (Rp {{ number_format($item->harga, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control" value="1" min="1" required>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">Tambah Menu</button>
                </div>
            </div>
        </form>

        {{-- Tabel Keranjang --}}
        <div class="table-responsive mb-4">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cart as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['nama_menu'] }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('transaksi-penjualan.removeFromCart', $item['id_menu']) }}"
                                    class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Keranjang masih kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Form untuk menyimpan transaksi --}}
        <form action="{{ route('transaksi-penjualan.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id_pelanggan" class="form-label">Pelanggan</label>
                    <select id="id_pelanggan" name="id_pelanggan" class="form-select">
                        <option value="" selected>Guest</option>
                        @foreach ($pelanggan as $customer)
                            <option value="{{ $customer->id_pelanggan }}">
                                {{ $customer->nama_pelanggan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                    <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            {{-- Total Biaya --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="total_biaya" class="form-label">Total Biaya</label>
                    <input type="text" id="total_biaya" class="form-control" value="Rp {{ number_format(array_sum(array_column($cart, 'subtotal')), 0, ',', '.') }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                    <select id="metode_pembayaran" name="metode_pembayaran" class="form-select" required>
                        <option value="" selected disabled>Pilih Metode Pembayaran</option>
                        <option value="tunai">Tunai</option>
                        <option value="kartu">Kartu Kredit/Debit</option>
                        <option value="transfer">Transfer Bank</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jumlah_uang" class="form-label">Jumlah Uang</label>
                    <input type="number" id="jumlah_uang" name="jumlah_uang" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="kembalian" class="form-label">Kembalian</label>
                    <input type="text" id="kembalian" class="form-control" value="Rp 0" readonly>
                </div>
                <div class="col-md-6">
                    <label for="user" class="form-label">User (Pengguna Login)</label>
                    <input type="text" id="user" class="form-control" value="{{ Auth::user()->name }}" readonly>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('transaksi-penjualan.index') }}" class="btn btn-secondary me-2">Batalkan</a>
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const jumlahUangInput = document.getElementById('jumlah_uang');
        const totalBiayaInput = document.getElementById('total_biaya');
        const kembalianInput = document.getElementById('kembalian');

        jumlahUangInput.addEventListener('input', () => {
            const jumlahUang = parseFloat(jumlahUangInput.value) || 0;
            const totalBiaya = parseFloat(totalBiayaInput.value.replace(/[^\d]/g, '')) || 0;

            const kembalian = jumlahUang - totalBiaya;
            kembalianInput.value = `Rp ${Math.max(kembalian, 0).toLocaleString('id-ID')}`;
        });
    });
</script>

@endsection
