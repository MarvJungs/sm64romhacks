<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'Admin', 'priority' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Moderator', 'priority' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Event Manager', 'priority' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Trusted', 'priority' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Regular', 'priority' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Banned', 'priority' => -1, 'created_at' => now(), 'updated_at' => now()]
        ];

        foreach ($roles as $role) {
            Role::insert($role);
        }
    }
}
