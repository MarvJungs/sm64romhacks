<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaguePointsSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('league_points_systems')->insert([
            ['name' => 'Points per Second'],
            ['name' => 'Points by Leaderboard Position'],
            ['name' => 'Points per Second and by Leaderboard Position']
        ]);
    }
}
