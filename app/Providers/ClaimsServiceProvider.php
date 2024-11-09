<?php

namespace App\Providers;

use App\Services\ClaimsService;
use App\Services\EdiX12837Service;
use Illuminate\Support\ServiceProvider;

class ClaimsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ClaimsService::class, function ($app) {
            return new ClaimsService($app->make(EdiX12837Service::class));
        });
    }

}