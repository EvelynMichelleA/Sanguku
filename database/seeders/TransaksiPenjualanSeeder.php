<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiPenjualanSeeder extends Seeder
{
    public function run(): void
    {
        // Seed data untuk transaksi_penjualan
        DB::table('transaksi_penjualan')->insert([
            [
                'id_pelanggan' => 1,
                'id_user' => 1,
                'total_biaya' => 150000.00,
                'tanggal_transaksi' => now(),
                'metode_pembayaran' => 'Cash',
                'subtotal'=>150000.00,
                'diskon'=>0.00,
                'jumlah_uang' => 200000.00,
                'kembalian' => 50000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pelanggan' => 2,
                'id_user' => 2,
                'total_biaya' => 10000000.00,
                'tanggal_transaksi' => now(),
                'metode_pembayaran' => 'Credit Card',
                'subtotal'=>100000.00,
                'diskon'=>0.00,
                'jumlah_uang' => 100000.00,
                'kembalian' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed data untuk detail_transaksi_penjualan
        DB::table('detail_transaksi_penjualan')->insert([
            [
                'id_transaksi_penjualan' => 1,
                'id_menu' => 1,
                'nama_menu' => 'Nasi Goreng',
                'jumlah' => 2,
                'harga_satuan' => 25000.00,
                'subtotal' => 50000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_transaksi_penjualan' => 1,
                'id_menu' => 2,
                'nama_menu' => 'Es Teh',
                'jumlah' => 4,
                'harga_satuan' => 10000.00,
                'subtotal' => 40000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_transaksi_penjualan' => 2,
                'id_menu' => 3,
                'nama_menu' => 'Mie Ayam',
                'jumlah' => 3,
                'harga_satuan' => 30000.00,
                'subtotal' => 90000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

