@extends('layouts.app')

@section('content')
    <div style="padding: 20px; background-color: #DEEFFE; min-height: 100vh;">
        <h2 style="font-size: 24px; font-weight: bold; color: #1e3a8a;">Transaksi Penjualan &gt;&gt; Tambah Transaksi
            Penjualan</h2>
        <div style="display: flex; margin-top: 20px;">
            <!-- Form User -->
            <div style="flex: 1; padding-right: 20px;">
                <div style="margin-bottom: 15px;">
                    <label>User</label>
                    <input type="text" value="{{ Auth::user()->username }}" readonly
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Tanggal</label>
                    <input type="date" value="{{ now()->format('Y-m-d') }}" readonly
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>No Telepon Pelanggan</label>
                    <input type="text" id="nomorTelepon" placeholder="Masukkan Nomor Telepon Pelanggan"
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" list="pelangganList" required>
                    <datalist id="pelangganList">
                        @foreach ($pelanggan as $p)
                            <option data-id="{{ $p->id_pelanggan }}" value="{{ $p->nomor_telepon }}">
                                {{ $p->nama_pelanggan }}
                            </option>
                        @endforeach
                    </datalist>
                    <input type="hidden" id="idPelanggan" name="id_pelanggan"> <!-- ID pelanggan -->
                </div>                
            </div>

            <!-- List Menu -->
            <div class="menu-container" style="display: flex; flex-wrap: wrap; gap: 10px;">
                @foreach ($menus as $menu)
                    <div class="menu-card" data-id="{{ $menu->id_menu }}" data-nama="{{ $menu->nama_menu }}" data-harga="{{ $menu->harga }}"
                        style="cursor: pointer; padding: 10px; border: 1px solid #ccc; border-radius: 5px; text-align: center; width: 120px;">
                        <img src="{{ asset('img/' . $menu->gambar_menu) }}" alt="{{ $menu->nama_menu }}" style="width: 100%; max-width: 100px; height: auto; margin-bottom: 10px;">
                        <p style="font-weight: bold;">{{ $menu->nama_menu }}</p>
                        <p style="color: #1e3a8a;">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>            
        </div>

        <!-- Checkout -->
        <div
            style="margin-top: 20px; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h3>Checkout</h3>
            <form id="checkoutForm" method="POST" action="{{ route('transaksi-penjualan.store') }}">
                @csrf
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #1e3a8a; color: white;">
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody id="checkout-table-body">
                        <!-- Baris menu akan ditambahkan di sini -->
                    </tbody>
                </table>
                <p><strong>Total:</strong> <span id="total-amount">Rp 0</span></p>
                <input type="hidden" id="menuData" name="menu_data"> <!-- Data menu dalam JSON -->
                <input type="hidden" id="totalTransaction" name="total_transaction">
                <button type="submit" id="checkoutButton"
                    style="padding: 10px 20px; background-color: #1e3a8a; color: white; border: none; border-radius: 5px;">Checkout</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Input pelanggan
            const nomorTeleponInput = document.getElementById('nomorTelepon');
            const idPelangganInput = document.getElementById('idPelanggan');
            const pelangganList = document.querySelectorAll('#pelangganList option');
        
            // Input menu
            const menuCards = document.querySelectorAll('.menu-card');
            const checkoutTableBody = document.querySelector('#checkout-table-body');
            const totalAmountElement = document.querySelector('#total-amount');
            const menuDataInput = document.getElementById('menuData');
            const totalTransactionInput = document.getElementById('totalTransaction');
        
            let totalAmount = 0;
            let menuData = [];
        
            // Event listener untuk nomor telepon pelanggan
            nomorTeleponInput.addEventListener('input', () => {
                const nomorTelepon = nomorTeleponInput.value;
                const selectedOption = Array.from(pelangganList).find(option => option.value === nomorTelepon);
        
                if (selectedOption) {
                    idPelangganInput.value = selectedOption.getAttribute('data-id');
                } else {
                    idPelangganInput.value = ''; // Kosongkan jika nomor tidak cocok
                }
            });
        
            // Event listener untuk menu card
            menuCards.forEach(card => {
                card.addEventListener('click', () => {
                    const idMenu = card.getAttribute('data-id'); // ID menu
                    const namaMenu = card.getAttribute('data-nama');
                    const hargaMenu = parseFloat(card.getAttribute('data-harga'));
        
                    let existingRow = Array.from(checkoutTableBody.children).find(row => {
                        return row.querySelector('.menu-name').textContent === namaMenu;
                    });
        
                    if (existingRow) {
                        let quantityElement = existingRow.querySelector('.menu-quantity');
                        let priceElement = existingRow.querySelector('.menu-price');
                        let quantity = parseInt(quantityElement.textContent) + 1;
                        quantityElement.textContent = quantity;
                        priceElement.textContent = `Rp ${(quantity * hargaMenu).toLocaleString('id-ID')}`;
        
                        // Update menuData
                        let menu = menuData.find(m => m.menu_id === idMenu);
                        menu.quantity++;
                    } else {
                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td class="menu-name">${namaMenu}</td>
                            <td class="menu-quantity">1</td>
                            <td class="menu-price">Rp ${hargaMenu.toLocaleString('id-ID')}</td>
                        `;
                        checkoutTableBody.appendChild(newRow);
        
                        // Tambahkan menu baru ke menuData
                        menuData.push({
                            menu_id: idMenu,
                            quantity: 1,
                            price: hargaMenu
                        });
                    }
        
                    totalAmount += hargaMenu;
                    totalAmountElement.textContent = `Rp ${totalAmount.toLocaleString('id-ID')}`;
                });
            });
        
            // Ketika formulir checkout dikirim
            const checkoutForm = document.getElementById('checkoutForm');
            checkoutForm.addEventListener('submit', (e) => {
                if (!idPelangganInput.value) {
                    e.preventDefault(); // Cegah pengiriman formulir jika pelanggan tidak valid
                    alert('Pilih pelanggan terlebih dahulu!');
                } else {
                    totalTransactionInput.value = totalAmount;
                    menuDataInput.value = JSON.stringify(menuData);
                }
            });
        });
    </script>
@endsection
