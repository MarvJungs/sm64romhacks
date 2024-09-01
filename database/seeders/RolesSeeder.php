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
            ['id' => 705528016914087976, 'name' => 'Administrator'],
            ['id' => 889424068644847688, 'name' => 'Dyno'],
            ['id' => 705528172581486704, 'name' => 'Moderator'],
            ['id' => 705530192839311381, 'name' => 'Site Helper'],
            ['id' => 738163465352511520, 'name' => 'Affiliates'],
            ['id' => 734916203390173275, 'name' => 'Server Booster'],
            ['id' => 725414492628058212, 'name' => 'Major Hack Creator'],
            ['id' => 725414675948240908, 'name' => 'Developer'],
            ['id' => 725414809385828354, 'name' => 'Hacker'],
            ['id' => 725412296179843172, 'name' => 'Speedrunner'],
            ['id' => 725414290655281244, 'name' => 'Kaizo Hack Completionist'],
            ['id' => 725414426345472021, 'name' => 'TASer'],
            ['id' => 812613944623104061, 'name' => 'srcom'],
            ['id' => 817029758440439829, 'name' => 'Biweekly Participant'],
            ['id' => 847213899412668426, 'name' => 'Server Comp Participant'],
            ['id' => 814935226182008832, 'name' => 'Hardcore Participant'],
            ['id' => 737674135747952660, 'name' => 'EventManager'],
            ['id' => 742522819321135125, 'name' => 'Timed Out'],
            ['id' => 814591196503998545, 'name' => 'Muted'],
            ['id' => 856976668337504296, 'name' => 'Private VC'],
            ['id' => 880128001008861305, 'name' => 'Connections Bot']
        ]);
    }
}
