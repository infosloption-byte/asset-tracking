<?php

namespace Sammy\AssetManage;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application views.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'assetManage');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application views.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('assetmanage', function($app){
            return new AssetManage;
        });
    }
}
