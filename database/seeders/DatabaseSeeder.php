<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new RolesSeeder())->run();
        (new AuthorsSeeder())->run();
        (new HacksSeeder())->run();
        (new HackTagsSeeder())->run();
        (new VersionsSeeder())->run();
        (new AuthorsVersionsSeeder())->run();
        (new RomhackRomhacktagsSeeder())->run();
        (new RomhackeventsSeeder())->run();
        (new CheatcodesSeeder())->run();
    }
}
