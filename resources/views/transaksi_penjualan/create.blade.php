@extends('layouts.app')

@section('content')
<div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
    <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a;">Transaksi Penjualan &gt;&gt; Tambah Transaksi Penjualan</h2>
    <div class="row mt-4">
      {{-- Kolom kanan: Menu --}}
<div class="col-md-4" style="background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h4 style="color: #1e3a8a; font-size: 18px;">Pilih Menu</h4>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Cari menu...">
        <button class="btn btn-primary">Cari</button>
    </div>
    <div class="menu-container" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-top: 15px;">
        @foreach ($menu as $item)
            <div class="card text-center" style="padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                {{-- Gambar menu --}}
                <img src="{{ asset('img/' . $item->gambar_menu) }}" alt="{{ $item->nama_menu }}" 
                    style="height: 100px; width: 100%; object-fit: cover; border-radius: 5px;">
                {{-- Detail menu --}}
                <h6 style="font-size: 14px; margin-top: 10px;">{{ $item->nama_menu }}</h6>
                <p style="font-size: 12px; color: #1e3a8a;">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                <form action="{{ route('transaksi-penjualan.addToCart') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_menu" value="{{ $item->id_menu }}">
                    <div class="d-flex align-items-center justify-content-center">
                        <input type="number" name="jumlah" class="form-control form-control-sm me-2" value="1" min="1" style="width: 50px;" required>
                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</div>

        <div class="col-md-8 d-flex flex-column gap-4">
            {{-- Detail Transaksi --}}
            <div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <h4 style="color: #1e3a8a; font-size: 18px;">Detail Transaksi</h4>
                <form action="{{ route('transaksi-penjualan.store') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_pelanggan" class="form-label">Pelanggan</label>
                            <select id="id_pelanggan" name="id_pelanggan" class="form-select">
                                <option value="" selected>Guest</option>
                                @foreach ($pelanggan as $customer)
                                    <option value="{{ $customer->id_pelanggan }}">{{ $customer->nama_pelanggan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                            <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

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
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('transaksi-penjualan.index') }}" class="btn btn-secondary me-2">Batalkan</a>
                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </div>
                </form>
            </div>

            {{-- Keranjang Belanja --}}
            <div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <h4 style="color: #1e3a8a; font-size: 18px;">Keranjang Belanja</h4>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead style="background-color: #1e3a8a; color: white;">
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
                                        <a href="{{ route('transaksi-penjualan.removeFromCart', $item['id_menu']) }}" class="btn btn-danger btn-sm">Hapus</a>
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
