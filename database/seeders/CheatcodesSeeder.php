<?php

namespace Database\Seeders;

use App\Models\Cheatcode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CheatcodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        include 'data/cheatcodes.php';

        foreach ($cheatcodes as $cheatcode) {
            Cheatcode::insert($cheatcode);
        }
    }
}
