<?php

namespace App\Console\Commands;

use App\Models\Newspost;
use App\Models\Romhack;
use App\Models\Romhackevent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Sitemap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Sitemap::create()
        ->add(Url::create('/cheats'))
            ->add(Url::create('/hacks'))
            ->add(Url::create('/home'))
            ->add(Url::create('/megapack'))
            ->add(Url::create('/news'))
            ->add(Url::create('/patcher'))
            ->add(Url::create('/streamer'))
            ->add(Newspost::all())
            ->add(Romhack::all())
            ->add(Romhackevent::all())
            ->add(User::all())
            ->writeToFile(public_path('sitemap.xml'));
    }
}
