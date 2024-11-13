<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\TransaksiPenjualan;
use App\Models\DetailTransaksiPenjualan;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\User;

class TransaksiPenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve existing users and customers
        $users = User::all();
        $pelanggan = Pelanggan::all();
        $menuItems = Menu::all();

        // Seed 10 transaksi penjualan
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $customer = $pelanggan->random();
            $totalBiaya = 0;

            // Create transaksi penjualan
            $transaksiPenjualan = TransaksiPenjualan::create([
                'id_pelanggan' => $customer->id_pelanggan,
                'id_user' => $user->id,
                'total_biaya' => 0, // Will be updated after adding details
                'tanggal_transaksi' => now(),
                'metode_pembayaran' => 'Cash',
            ]);

            // Add 1-3 menu items to each transaksi
            $detailCount = rand(1, 3);
            for ($j = 0; $j < $detailCount; $j++) {
                $menu = $menuItems->random();
                $jumlah = rand(1, 5);
                $subtotal = $menu->harga * $jumlah;
                $totalBiaya += $subtotal;

                DetailTransaksiPenjualan::create([
                    'id_transaksi_penjualan' => $transaksiPenjualan->id_transaksi_penjualan,
                    'id_menu' => $menu->id_menu,
                    'nama_menu' => $menu->nama_menu,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $menu->harga,
                    'subtotal' => $subtotal,
                ]);
            }

            // Update total biaya after adding details
            $transaksiPenjualan->total_biaya = $totalBiaya;
            $transaksiPenjualan->save();
        }
    }
}
