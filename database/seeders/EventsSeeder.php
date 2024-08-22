<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            ['slug' => 'starrevengeseriesrelay2024', 'name' => 'Star Revenge Series 100% Relay', 'start_utc' => '2024-04-12 16:00:00', 'end_utc' => '2024-04-14 20:50:00', 'marathon' => true],
            ['slug' => 'wsrm2024', 'name' => 'Winter SM64 ROM Hacks Marathon 2024', 'start_utc' => '2024-01-02 00:00:00', 'end_utc' => '2024-01-06 04:15:00', 'marathon' => true],
            ['slug' => 'league2023', 'name' => 'SM64 ROM Hacks League 2023', 'start_utc' => '2023-09-16 18:20:00', 'end_utc' => '2023-11-01 04:00:00', 'marathon' => false],
            ['slug' => 'ssrm2023', 'name' => 'Summer SM64 ROM Hacks Marathon 2023', 'start_utc' => '2023-08-03 02:15:00', 'end_utc' => '2024-08-07 03:00:00', 'marathon' => true],
            ['slug' => 'wsrm2023', 'name' => 'Winter SM64 ROM Hacks Marathon 2023', 'start_utc' => '2023-01-05 06:00:00', 'end_utc' => '2023-01-09 01:25:00', 'marathon' => true],
            ['slug' => 'league2022', 'name' => 'SM64 ROM Hacks League 2022', 'start_utc' => '2022-09-17 18:20:00', 'end_utc' => '2022-12-01 04:00:00', 'marathon' => false],
            ['slug' => 'ssrm2022', 'name' => 'Summer SM64 ROM Hacks Marathon 2022', 'start_utc' => '2022-07-28 10:00:00', 'end_utc' => '2022-08-02 02:45:00', 'marathon' => true],
            ['slug' => 'wsrm2022', 'name' => 'Winter SM64 ROM Hacks Marathon 2022', 'start_utc' => '2022-01-06 00:15:00', 'end_utc' => '2022-01-10 00:25:00', 'marathon' => true],
            ['slug' => 'ssrm2021', 'name' => 'Summer SM64 ROM Hacks Marathon 2021', 'start_utc' => '2021-07-29 12:15:00', 'end_utc' => '2021-08-03 00:30:00', 'marathon' => true],
            ['slug' => 'wsrm2021', 'name' => 'Winter SM64 ROM Hacks Marathon 2021', 'start_utc' => '2020-12-27 13:45:00', 'end_utc' => '2020-12-30 17:40:00', 'marathon' => true],
            ['slug' => 'ssrm2020', 'name' => 'Summer SM64 ROM Hacks Marathon 2020', 'start_utc' => '2020-08-06 10:15:00', 'end_utc' => '2020-08-09 22:50:00', 'marathon' => true],
            ['slug' => 'wsrm2020', 'name' => 'Winter SM64 ROM Hacks Marathon 2020', 'start_utc' => '2020-01-02 20:00:00', 'end_utc' => '2020-01-05 23:35:00', 'marathon' => true],
            ['slug' => 'ssrm2019', 'name' => 'Summer SM64 ROM Hacks Marathon 2019', 'start_utc' => '2019-08-01 14:00:00', 'end_utc' => '2019-08-03 22:10:00', 'marathon' => true],
            ['slug' => 'wsrm2019', 'name' => 'Winter SM64 ROM Hacks Marathon 2019', 'start_utc' => '2019-01-11 07:00:00', 'end_utc' => '2019-01-14 06:40:00', 'marathon' => true],
            ['slug' => 'ssrm2018', 'name' => 'Summer SM64 ROM Hacks Marathon 2018', 'start_utc' => '2018-08-10 11:45:00', 'end_utc' => '2018-08-13 00:35:00', 'marathon' => true],
            ['slug' => 'wsrm2018', 'name' => 'Winter SM64 ROM Hacks Marathon 2018', 'start_utc' => '2018-01-04 12:00:00', 'end_utc' => '2018-01-07 03:20:00', 'marathon' => true]
        ]);
    }
}
