<?php

namespace Sammy\ManufacturerManage;

use Illuminate\Support\ServiceProvider;

class ManufacturerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application views.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'manufacturerManage');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application views.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('manufacturermanage', function($app){
            return new ManufacturerManage;
        });
    }
}
