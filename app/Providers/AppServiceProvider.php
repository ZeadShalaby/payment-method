<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MyFatoorahService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MyFatoorahService::class, function ($app) {
            return new MyFatoorahService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
