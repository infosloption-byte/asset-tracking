<?php

namespace Sammy\AssetModal;

use Illuminate\Support\ServiceProvider;

class AssetModalServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application views.
	 *
	 * @return void
	 */
	public function boot() {
		$this->loadViewsFrom(__DIR__ . '/../views', 'assetModal');
		require __DIR__ . '/Http/routes.php';
	}

	/**
	 * Register the application views.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind('assetModal', function ($app) {
			return new AssetModal;
		});
	}
}
