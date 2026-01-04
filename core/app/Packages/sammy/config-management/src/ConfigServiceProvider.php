<?php

namespace Sammy\ConfigManage;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application views.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'configManage');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application views.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('configManage', function($app){
            return new ServiceManage;
        });
    }
}
