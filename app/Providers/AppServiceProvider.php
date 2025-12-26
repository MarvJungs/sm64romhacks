<?php

namespace App\Providers;

use App\Models\Romhack;
use App\Models\Romhackevent;
use Illuminate\Support\Facades\View;

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
            Paginator::useBootstrapFive();
            View::composer(
                'components.navbar', function ($view) {
                    $events = RomHackevent::orderBy('start_utc', 'desc')->get();
                    $amountPending = Romhack::where('verified', '=', 0, 'and', 'rejected', '=', 0)->get()->count();
                    $view->with('events', $events);
                    $view->with('amountPending', $amountPending);
                }
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
        Event::listen(
            function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
                $event->extendSocialite('discord', \SocialiteProviders\Discord\Provider::class);
                $event->extendSocialite('twitch', \SocialiteProviders\Twitch\Provider::class);
            }
        );
    }
}
