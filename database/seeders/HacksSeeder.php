<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Romhack;

class HacksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        include 'data/hacks.php';

        foreach ($hacks as $hack) {
            Romhack::insert($hack);
        }
    }
}
