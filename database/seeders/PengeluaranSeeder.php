<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengeluaranSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengeluaran')->insert([
            [
                'id_pengeluaran' => 1,
                'id' => 1,
                'nama_pengeluaran' => 'Beli Sayur',
                'total_pengeluaran' => 250000.00,
                'tanggal_pengeluaran' => '2024-10-10',
                'keterangan_pengeluaran' => 'Pembelian sayur segar untuk menu cafe',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pengeluaran' => 2,
                'id' => 1,
                'nama_pengeluaran' => 'Beli Kopi',
                'total_pengeluaran' => 750000.00,
                'tanggal_pengeluaran' => '2024-10-10',
                'keterangan_pengeluaran' => 'Pembelian kopi premium untuk cafe',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pengeluaran' => 3,
                'id' => 2,
                'nama_pengeluaran' => 'Bahan Produksi Lainnya',
                'total_pengeluaran' => 500000.00,
                'tanggal_pengeluaran' => '2024-10-10',
                'keterangan_pengeluaran' => 'Pembelian bahan baku produksi lain untuk cafe',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pengeluaran' => 4,
                'id' => 2,
                'nama_pengeluaran' => 'Pembayaran Listrik',
                'total_pengeluaran' => 75000.00,
                'tanggal_pengeluaran' => '2024-10-10',
                'keterangan_pengeluaran' => 'Pembayaran tagihan listrik untuk cafe',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pengeluaran' => 5,
                'id' => 1,
                'nama_pengeluaran' => 'Pembayaran Air',
                'total_pengeluaran' => 50000.00,
                'tanggal_pengeluaran' => '2024-10-10',
                'keterangan_pengeluaran' => 'Pembayaran tagihan air untuk cafe',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pengeluaran' => 6,
                'id' => 1,
                'nama_pengeluaran' => 'Gaji Karyawan',
                'total_pengeluaran' => 1500000.00,
                'tanggal_pengeluaran' => '2024-10-10',
                'keterangan_pengeluaran' => 'Pembayaran gaji karyawan cafe bulan ini',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pengeluaran' => 7,
                'id' => 2,
                'nama_pengeluaran' => 'Pemasaran',
                'total_pengeluaran' => 300000.00,
                'tanggal_pengeluaran' => '2024-10-10',
                'keterangan_pengeluaran' => 'Biaya pemasaran dan promosi cafe',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pengeluaran' => 8,
                'id' => 2,
                'nama_pengeluaran' => 'Biaya Kebersihan',
                'total_pengeluaran' => 25000.00,
                'tanggal_pengeluaran' => '2024-10-10',
                'keterangan_pengeluaran' => 'Biaya kebersihan area cafe',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pengeluaran' => 9,
                'id' => 1,
                'nama_pengeluaran' => 'Pembelian Stok',
                'total_pengeluaran' => 600000.00,
                'tanggal_pengeluaran' => '2024-10-10',
                'keterangan_pengeluaran' => 'Pembelian stok barang untuk dijual di cafe',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pengeluaran' => 10,
                'id' => 2,
                'nama_pengeluaran' => 'Asuransi',
                'total_pengeluaran' => 200000.00,
                'tanggal_pengeluaran' =>'2024-10-10',
                'keterangan_pengeluaran' => 'Pembayaran premi asuransi untuk cafe',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}