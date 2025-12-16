<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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
        // Rate limiter for Resend API: 2 requests per second
        RateLimiter::for('resend-api', function (object $job) {
            return Limit::perSecond(2);
        });

        // Rate limiter for deliverability: 400 emails per hour
        // Prevents spam blacklisting by spreading sends over time
        RateLimiter::for('email-deliverability', function (object $job) {
            return Limit::perHour(400);
        });
    }
}
