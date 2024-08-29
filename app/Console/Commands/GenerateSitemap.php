<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Hack;
use App\Models\News;
use App\Models\User;
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
    protected $description = 'Generate the sitemap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/home'))
            ->add(Url::create('/hacks'))
            ->add(Url::create('/megapack'))
            ->add(Url::create('/cheats'))
            ->add(Url::create('/patcher'))
            ->add(Url::create('/streams'))
            ->add(Event::all())
            ->add(Hack::where('verified', '=', 1)->get())
            ->add(News::all())
            ->add(User::all())
            ->writeToFile(public_path('sitemap.xml'));
    }
}
