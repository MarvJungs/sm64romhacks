<?php

namespace Database\Seeders;

use App\Models\Romhacktag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HackTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        include 'data/tags.php';

        foreach ($tags as $tag) {
            Romhacktag::insert($tag);
        }
    }
}
