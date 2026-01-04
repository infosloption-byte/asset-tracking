<?php

namespace Sammy\ServiceTypeManage;

use Illuminate\Support\ServiceProvider;

class ServiceTypeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application views.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'serviceTypeManage');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application views.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('servicetypemanage', function($app){
            return new ServiceTypeManage;
        });
    }
}
