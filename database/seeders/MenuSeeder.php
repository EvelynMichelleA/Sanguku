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
                'gambar_menu' => 'menu/image1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 2,
                'nama_menu' => 'Mie Goreng',
                'harga' => 18000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'menu/image2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 3,
                'nama_menu' => 'Ayam Penyet',
                'harga' => 25000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'menu/image3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 4,
                'nama_menu' => 'Sate Ayam',
                'harga' => 22000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'menu/image4.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 5,
                'nama_menu' => 'Es Teh Manis',
                'harga' => 5000.00,
                'jenis_menu' => 'Minuman',
                'gambar_menu' => 'menu/image5.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 6,
                'nama_menu' => 'Kopi Hitam',
                'harga' => 8000.00,
                'jenis_menu' => 'Minuman',
                'gambar_menu' => 'menu/image6.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 7,
                'nama_menu' => 'Roti Bakar',
                'harga' => 15000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'menu/image7.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 8,
                'nama_menu' => 'Ricebowl Ayam',
                'harga' => 30000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'menu/image8.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 9,
                'nama_menu' => 'Pasta Carbonara',
                'harga' => 40000.00,
                'jenis_menu' => 'Makanan',
                'gambar_menu' => 'menu/image9.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_menu' => 10,
                'nama_menu' => 'Smoothie Mangga',
                'harga' => 15000.00,
                'jenis_menu' => 'Minuman',
                'gambar_menu' => 'menu/image10.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
