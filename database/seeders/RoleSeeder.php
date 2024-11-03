<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('role')->insert([
            [
                'id_role' => 1,
                'nama_role' => 'Kasir',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'id_role' => 2,
                'nama_role' => 'Owner',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'id_role' => 3,
                'nama_role' => 'Supervisor',
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);
    }
}
