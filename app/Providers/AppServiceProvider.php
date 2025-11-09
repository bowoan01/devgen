<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        if (config('app.force_https', false) || app()->environment('production')) {
            URL::forceScheme('https');
        }

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(3)->by(
                $request->user()?->getAuthIdentifier() ?: $request->ip()
            );
        });
    }
}
