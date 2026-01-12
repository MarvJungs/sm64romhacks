<?php

namespace App\Providers;

use App\Services\YoutubeService;
use Illuminate\Support\ServiceProvider;

class YoutubeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(YoutubeService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
