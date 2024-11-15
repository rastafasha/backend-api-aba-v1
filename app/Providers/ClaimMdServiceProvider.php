<?php

namespace App\Providers;

use App\Services\ClaimMdService;
use Illuminate\Support\ServiceProvider;

class ClaimMdServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ClaimMdService::class, function ($app) {
            return new ClaimMdService();
        });
    }
}