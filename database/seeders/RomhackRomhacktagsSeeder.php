<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RomhackRomhacktagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        include 'data/hack_tag.php';

        foreach ($hack_tag as $element) {
            DB::table('romhack_romhacktag')->insert($element);
        }
    }
}
