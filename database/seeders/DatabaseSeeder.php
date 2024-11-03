<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PelangganSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(PengeluaranSeeder::class);
        $this->call(TransaksiPenjualanSeeder::class);
        $this->call(DetailTransaksiPenjualanSeeder::class);
    }
}
