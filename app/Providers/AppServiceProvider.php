<?php

namespace App\Providers;

use App\Models\Notes\NoteBcba;
use App\Models\Notes\NoteRbt;
use App\Observers\NoteBcbaObserver;
use App\Observers\NoteRbtObserver;
use App\Services\EdiX12837Service;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EdiX12837Service::class, function ($app) {
            return new EdiX12837Service();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        NoteRbt::observe(NoteRbtObserver::class);
        NoteBcba::observe(NoteBcbaObserver::class);
    }
}
