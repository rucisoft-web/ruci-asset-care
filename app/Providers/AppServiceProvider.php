<?php

namespace App\Providers;

use App\Support\CurrentCompany;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // scoped: direset setiap permintaan HTTP dan setiap job antrean.
        $this->app->scoped(CurrentCompany::class);
    }

    public function boot(): void
    {
        Carbon::setLocale('id');

        RateLimiter::for('qr-report', fn (Request $request) => Limit::perMinute(config('asset.qr_reports_per_minute'))->by($request->ip()));
    }
}
