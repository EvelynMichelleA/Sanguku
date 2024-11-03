<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        DB::table('pelanggan')->insert([
            [
                'id_pelanggan' => 1,
                'nama_pelanggan' => 'Andi Setiawan',
                'nomor_telepon' => '081234567890',
                'email_pelanggan' => 'andi.setiawan@example.com',
                'jumlah_poin' => rand(1000, 5000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pelanggan' => 2,
                'nama_pelanggan' => 'Siti Aminah',
                'nomor_telepon' => '082345678901',
                'email_pelanggan' => 'siti.aminah@example.com',
                'jumlah_poin' => rand(1000, 5000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pelanggan' => 3,
                'nama_pelanggan' => 'Budi Santoso',
                'nomor_telepon' => '083456789012',
                'email_pelanggan' => 'budi.santoso@example.com',
                'jumlah_poin' => rand(1000, 5000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pelanggan' => 4,
                'nama_pelanggan' => 'Rina Puspitasari',
                'nomor_telepon' => '084567890123',
                'email_pelanggan' => 'rina.puspitasari@example.com',
                'jumlah_poin' => rand(1000, 5000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pelanggan' => 5,
                'nama_pelanggan' => 'Toni Prasetyo',
                'nomor_telepon' => '085678901234',
                'email_pelanggan' => 'toni.prasetyo@example.com',
                'jumlah_poin' => rand(1000, 5000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pelanggan' => 6,
                'nama_pelanggan' => 'Dewi Ratnasari',
                'nomor_telepon' => '086789012345',
                'email_pelanggan' => 'dewi.ratnasari@example.com',
                'jumlah_poin' => rand(1000, 5000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pelanggan' => 7,
                'nama_pelanggan' => 'Joko Susilo',
                'nomor_telepon' => '087890123456',
                'email_pelanggan' => 'joko.susilo@example.com',
                'jumlah_poin' => rand(1000, 5000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pelanggan' => 8,
                'nama_pelanggan' => 'Siti Khadijah',
                'nomor_telepon' => '088901234567',
                'email_pelanggan' => 'siti.khadijah@example.com',
                'jumlah_poin' => rand(1000, 5000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pelanggan' => 9,
                'nama_pelanggan' => 'Rudi Hartono',
                'nomor_telepon' => '089012345678',
                'email_pelanggan' => 'rudi.hartono@example.com',
                'jumlah_poin' => rand(1000, 5000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pelanggan' => 10,
                'nama_pelanggan' => 'Lina Marlina',
                'nomor_telepon' => '090123456789',
                'email_pelanggan' => 'lina.marlina@example.com',
                'jumlah_poin' => rand(1000, 5000),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
