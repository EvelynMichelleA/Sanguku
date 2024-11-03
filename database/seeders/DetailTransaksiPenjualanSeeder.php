<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailTransaksiPenjualanSeeder extends Seeder
{
    public function run()
    {
        DB::table('detail_transaksi_penjualan')->insert([
            [
                'id_transaksi_penjualan' => 1,
                'id_menu' => 1, 
                'jumlah' => 2,
            ],
            [
                'id_transaksi_penjualan' => 2,
                'id_menu' => 2, 
                'jumlah' => 1,
            ],
            [
                'id_transaksi_penjualan' => 3,
                'id_menu' => 3, 
                'jumlah' => 3,
            ],
            [
                'id_transaksi_penjualan' => 4,
                'id_menu' => 4, 
                'jumlah' => 1,
            ],
            [
                'id_transaksi_penjualan' => 5,
                'id_menu' => 1,
                'jumlah' => 1,
            ],
            [
                'id_transaksi_penjualan' => 6,
                'id_menu' => 5,
                'jumlah' => 2,
            ],
            [
                'id_transaksi_penjualan' => 7,
                'id_menu' => 2,
                'jumlah' => 5,
            ],
            [
                'id_transaksi_penjualan' => 8,
                'id_menu' => 4,
                'jumlah' => 2,
            ],
            [
                'id_transaksi_penjualan' => 9,
                'id_menu' => 3,
                'jumlah' => 4,
            ],
            [
                'id_transaksi_penjualan' => 10,
                'id_menu' => 5,
                'jumlah' => 1,
            ],
        ]);
    }
}
