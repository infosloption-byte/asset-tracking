<?php

namespace Sammy\AssetUpgradeManage;

use Illuminate\Support\ServiceProvider;

class AssetUpgradeServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application views.
	 *
	 * @return void
	 */
	public function boot() {
		$this->loadViewsFrom(__DIR__ . '/../views', 'views');
		require __DIR__ . '/Http/routes.php';
	}

	/**
	 * Register the application views.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind('views', function ($app) {
			return new AssetModal;
		});
	}
}
