<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        include 'data/users.php';
        foreach ($users as $user) {
            User::insert(
                [
                    'name' => $user['username'],
                    'email' => $user['email'],
                    'email_verified_at' => $user['created_at'],
                    'name_updated_at' => $user['updated_at'],
                    'password' => null,
                    'description' => null,
                    'twitch_id' => null,
                    'discord_id' => $user['id'],
                    'avatar' => '/images/profile/default.png',
                    'country_id' => null,
                    'remember_token' => null,
                    'created_at' => $user['created_at'],
                    'updated_at' => $user['updated_at']
                ]
            );
        }

        User::all()->each(
            function (User $user) {
                $defaultRoles = Role::where(['priority' => Role::max('priority')])->get();
                $user->roles()->attach($defaultRoles);
            }
        );
    }
}
