<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run()
    {
        DB::table('menu')->insert([
            [
                'id_menu' => 1,
                'nama_menu' => 'Nasi Goreng',
                'harga' => 20000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'nasigoreng.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 2,
                'nama_menu' => 'Mie Goreng',
                'harga' => 18000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'miegoreng.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 3,
                'nama_menu' => 'Ayam Penyet',
                'harga' => 25000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'ayampenyet.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 4,
                'nama_menu' => 'Sate Ayam',
                'harga' => 22000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'sateayam.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 5,
                'nama_menu' => 'Es Teh Manis',
                'harga' => 5000.00,
                'jenis_menu' => 'Minuman',
                'gambar_menu' => 'esteh.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 6,
                'nama_menu' => 'Kopi Hitam',
                'harga' => 8000.00,
                'jenis_menu' => 'Minuman',
                'gambar_menu' => 'kopihitam.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 7,
                'nama_menu' => 'Roti Bakar',
                'harga' => 15000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'rotibakar.jpg',
                'created_at' => '2021-02-02',
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 8,
                'nama_menu' => 'Ricebowl Ayam',
                'harga' => 30000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'ricebowlayam.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 9,
                'nama_menu' => 'Pasta Carbonara',
                'harga' => 40000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'carbonara.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 10,
                'nama_menu' => 'Smoothie Mangga',
                'harga' => 15000.00,
                'jenis_menu' => 'Minuman',
                'gambar_menu' => 'smoothiemangga.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
