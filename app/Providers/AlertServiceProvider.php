<?php

namespace App\Providers;

use App\Ux\Alert;
use Illuminate\Support\ServiceProvider;

class AlertServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('alert', function () {
            return $this->app->make('App\Ux\SweetAlert\SweetAlertNotifier');
        });
    }
}
