<?php

namespace Sammy\CheckInout;

use Illuminate\Support\ServiceProvider;

class CheckInoutServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application views.
	 *
	 * @return void
	 */
	public function boot() {
		$this->loadViewsFrom(__DIR__ . '/../views', 'checkinout');
		require __DIR__ . '/Http/routes.php';
	}

	/**
	 * Register the application views.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind('checkinout', function ($app) {
			return new CheckInout;
		});
	}
}
