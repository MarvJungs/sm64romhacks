<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaguesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leagues = array(
            array('id' => '1', 'event_id' => '4', 'league_points_system_id' => '2', 'created_at' => '2024-09-11 21:24:25', 'updated_at' => '2024-09-11 21:24:25'),
            array('id' => '2', 'event_id' => '7', 'league_points_system_id' => '1', 'created_at' => '2024-09-11 21:53:06', 'updated_at' => '2024-09-11 21:53:06'),
            array('id' => '3', 'event_id' => '18', 'league_points_system_id' => '3', 'created_at' => '2024-09-15 15:49:13', 'updated_at' => '2024-09-15 15:49:13')
        );
        DB::table('leagues')->insert($leagues);
    }
}
