<?php

namespace Database\Seeders;

use App\Models\Romhackevent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RomhackeventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        include 'data/romhackevents.php';

        foreach ($romhackevents as $romhackevent) {
            Romhackevent::insert($romhackevent);
        }
    }
}
