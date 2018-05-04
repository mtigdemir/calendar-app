<?php

namespace App\Providers;

use App\Contracts\EventSearchInterface;
use App\Services\EventSearchService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EventSearchInterface::class, EventSearchService::class);
    }
}
