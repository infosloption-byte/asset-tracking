<?php namespace App\Providers;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application views.
	 *
	 * @param  \Illuminate\Bus\Dispatcher  $dispatcher
	 * @return void
	 */
	public function boot(Dispatcher $dispatcher)
	{
		$dispatcher->mapUsing(function($command)
		{
			return Dispatcher::simpleMapping(
				$command, 'App\Commands', 'App\Handlers\Commands'
			);
		});
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
