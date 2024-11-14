@extends('layouts.app')

@section('content')
    <div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a;">Transaksi Penjualan &gt;&gt; Tambah Transaksi
            Penjualan</h2>
        <div style="display: flex; margin-top: 20px;">
            <!-- Pilih Menu -->
            <div class="menu-container" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 15px;">
                @foreach ($menu as $item)
                    <div class="menu-card"
                        data-id="{{ $item->id_menu }}"
                        data-jumlah="1"
                        style="cursor: pointer; padding: 10px; border: 1px solid #ccc; border-radius: 5px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <div class="image-container" style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100px; overflow: hidden;">
                            <img src="{{ asset('img/' . $item->gambar_menu) }}" alt="{{ $item->nama_menu }}"
                                style="max-width: 100%; max-height: 100%; object-fit: cover;">
                        </div>
                        <p style="font-weight: bold; margin: 10px 0 5px;">{{ $item->nama_menu }}</p>
                        <p style="color: #1e3a8a;">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <form action="{{ route('transaksi-penjualan.addToCart') }}" method="POST" class="menu-form" style="display: none;">
                            @csrf
                            <input type="hidden" name="id_menu" value="{{ $item->id_menu }}">
                            <input type="hidden" name="jumlah" value="1">
                        </form>
                    </div>
                @endforeach
            </div>
            
            
            <!-- Detail Transaksi dan Keranjang Belanja -->
            <div style="flex: 1;">
                <div
                    style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h4 style="font-size: 18px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: center;">Keranjang Belanja</h4>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px;">
                        <thead style="background-color: #1e3a8a; color: white;">
                            <tr>
                                <th style="padding: 10px; text-align: left;">No</th>
                                <th style="padding: 10px; text-align: left;">Menu</th>
                                <th style="padding: 10px; text-align: left;">Jumlah</th>
                                <th style="padding: 10px; text-align: left;">Harga Satuan</th>
                                <th style="padding: 10px; text-align: left;">Subtotal</th>
                                <th style="padding: 10px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cart as $index => $item)
                                <tr>
                                    <td style="padding: 10px;">{{ $loop->iteration }}</td>
                                    <td style="padding: 10px;">{{ $item['nama_menu'] }}</td>
                                    <td style="padding: 10px;">{{ $item['jumlah'] }}</td>
                                    <td style="padding: 10px;">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td style="padding: 10px;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <a href="{{ route('transaksi-penjualan.removeFromCart', $item['id_menu']) }}"
                                            class="btn btn-danger btn-sm"
                                            style="padding: 5px 10px; border-radius: 5px; background-color: #e3342f; color: #fff; border: none;">Hapus</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center" style="padding: 10px;">Keranjang masih kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Detail Transaksi -->
                <div
                    style="margin-bottom: 20px; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h4 style="font-size: 18px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; text-align: center;">Detail Transaksi</h4>
                    <form action="{{ route('transaksi-penjualan.store') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 15px;">
                            <label for="id_pelanggan" style="font-weight: bold;">Pelanggan</label>
                            <select id="id_pelanggan" name="id_pelanggan" class="form-control"
                                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                <option value="" selected>Guest</option>
                                @foreach ($pelanggan as $customer)
                                    <option value="{{ $customer->id_pelanggan }}">{{ $customer->nama_pelanggan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label for="tanggal_transaksi" style="font-weight: bold;">Tanggal Transaksi</label>
                            <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" class="form-control"
                                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;" value="{{ date('Y-m-d') }}" readonly>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label for="total_biaya" style="font-weight: bold;">Total Biaya</label>
                            <input type="text" id="total_biaya" class="form-control"
                                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;"
                                value="Rp {{ number_format(array_sum(array_column($cart, 'subtotal')), 0, ',', '.') }}" readonly>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label for="metode_pembayaran" style="font-weight: bold;">Metode Pembayaran</label>
                            <select id="metode_pembayaran" name="metode_pembayaran" class="form-control"
                                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;" required>
                                <option value="" selected disabled>Pilih Metode Pembayaran</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Kartu">Kartu Kredit/Debit</option>
                                <option value="QRis">QRis</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label for="jumlah_uang" style="font-weight: bold;">Jumlah Uang</label>
                            <input type="number" id="jumlah_uang" name="jumlah_uang" class="form-control"
                                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;" required>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label for="kembalian" style="font-weight: bold;">Kembalian</label>
                            <input type="text" id="kembalian" class="form-control"
                                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;" value="Rp 0" readonly>
                        </div>
                        <div style="text-align: right;">
                            <a href="{{ route('transaksi-penjualan.index') }}" class="btn btn-secondary me-2"
                                style="padding: 10px 20px; border-radius: 5px; background-color: #ccc; border: none; color: #333;">Batalkan</a>
                            <button type="submit" class="btn btn-primary"
                                style="padding: 10px 20px; border-radius: 5px; background-color: #1e3a8a; border: none; color: #fff;">Simpan Transaksi</button>
                        </div>
                    </form>
                </div>
            
                <!-- Keranjang Belanja -->
    
            </div>
            
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const jumlahUangInput = document.getElementById('jumlah_uang');
        const totalBiayaInput = document.getElementById('total_biaya');
        const kembalianInput = document.getElementById('kembalian');
        const menuCards = document.querySelectorAll('.menu-card');

        jumlahUangInput.addEventListener('input', () => {
            const jumlahUang = parseFloat(jumlahUangInput.value) || 0;
            const totalBiaya = parseFloat(totalBiayaInput.value.replace(/[^\d]/g, '')) || 0;

            const kembalian = jumlahUang - totalBiaya;
            kembalianInput.value = `Rp ${Math.max(kembalian, 0).toLocaleString('id-ID')}`;
        });
        menuCards.forEach(card => {
        card.addEventListener('click', () => {
            const form = card.querySelector('.menu-form');
            form.submit();
        });
    });
    });

</script>
@endsection
