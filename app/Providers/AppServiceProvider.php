<?php

namespace App\Providers;

use App\Models\NavbarLink;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * @return void
     */
    public function register(): void
    {
        //
    }
    
    /**
     * Bootstrap any application services.
     * 
     * @return void
     */
    public function boot(): void
    {
        try {
            view()->share('navbar_links', NavbarLink::all());
        } catch (\Throwable $th) {
            //throw $th;
        }
        Event::listen(
            function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
                $event->extendSocialite('discord', \SocialiteProviders\Discord\Provider::class);
                $event->extendSocialite('twitch', \SocialiteProviders\Twitch\Provider::class);
            }
        );

        Paginator::useBootstrapFour();
    }
}
