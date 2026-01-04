<?php

namespace Sammy\BarcodeManage;

use Illuminate\Support\ServiceProvider;

class BarcodeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application views.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'barcodeManage');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application views.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('barcodeManage', function($app){
            return new ServiceManage;
        });
    }
}
