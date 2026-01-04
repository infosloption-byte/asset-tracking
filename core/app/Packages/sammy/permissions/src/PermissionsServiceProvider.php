<?php

namespace Sammy\Permissions;

use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application views.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'permissions');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application views.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('permissions', function($app){
            return new Permissions;
        });
    }
}
