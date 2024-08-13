<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'owner', 'priority' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'priority' =>  2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'moderator', 'priority' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'event-manager', 'priority' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user', 'priority' => 5, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
