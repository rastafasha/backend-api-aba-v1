<?php

namespace App\Providers;

use App\Services\WeeklyReportService;
use Illuminate\Support\ServiceProvider;

class WeeklyReportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WeeklyReportService::class, function ($app) {
            return new WeeklyReportService();
        });
    }
}
