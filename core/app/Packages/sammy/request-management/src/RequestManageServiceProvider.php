<?php

namespace Sammy\RequestManage;

use Illuminate\Support\ServiceProvider;

class RequestManageServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application views.
	 *
	 * @return void
	 */
	public function boot() {
		$this->loadViewsFrom(__DIR__ . '/../views', 'requestManage');
		require __DIR__ . '/Http/routes.php';
	}

	/**
	 * Register the application views.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind('requestManage', function ($app) {
			return new RequestManage;
		});
	}
}
