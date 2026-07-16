<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application views.
	 *
	 * @return void
	 */
	public function boot()
	{
		// master_nginx terminates SSL and proxies to this container over plain
		// HTTP, so Laravel doesn't otherwise know the original request was
		// HTTPS - without this, asset()/url() generate http:// links, which
		// the browser then blocks as mixed content on an https:// page.
		if (env('FORCE_HTTPS', false)) {
			URL::forceScheme('https');
		}
	}

	/**
	 * Register any application views.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}