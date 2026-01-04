<?php
/**
 * LOCATION MANAGEMENT ROUTES
 *
 * @version 1.0.0
 * @author sriya <csriyarathne@gmail.com>
 * @copyright 2015 Yasith Samarawickrama
 */

/**
 * LOCATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix' => 'location', 'namespace' => 'Sammy\Location\Http\Controllers'], function () {
		/**
		 * GET Routes
		 */
		Route::get('add', [
			'as' => 'location.add', 'uses' => 'LocationController@addView',
		]);

		Route::get('edit/{id}', [
			'as' => 'location.edit', 'uses' => 'LocationController@editView',
		]);

		Route::get('get-location', [
			'as' => 'location.get-location', 'uses' => 'LocationController@getLocation',
		]);

		Route::get('get-ground-location', [
			'as' => 'location.get-ground-location', 'uses' => 'LocationController@getGroundLocation',
		]);

		Route::get('list', [
			'as' => 'location.list', 'uses' => 'LocationController@listView',
		]);

		Route::get('json/list', [
			'as' => 'location.list', 'uses' => 'LocationController@jsonLocList',
		]);

		Route::get('main-location', [
			'as' => 'location.main-location', 'uses' => 'LocationController@locationMain',
		]);

		Route::get('location-hierachy', [
			'as' => 'location.location-hierachy', 'uses' => 'LocationController@locationHierachy',
		]);

		Route::get('jsonLocationHierarchy', [
			'as' => 'location.list', 'uses' => 'LocationController@jsonLocList',
		]);

		/**
		 * POST Routes
		 */
		Route::post('add', [
			'as' => 'location.add', 'uses' => 'LocationController@add',
		]);

		Route::post('edit/{id}', [
			'as' => 'location.edit', 'uses' => 'LocationController@edit',
		]);

		Route::post('status', [
			'as' => 'location.status', 'uses' => 'LocationController@status',
		]);

	});

	Route::group(['prefix' => 'location/type', 'namespace' => 'Sammy\Location\Http\Controllers'], function () {
		/**
		 * GET Routes
		 */
		Route::get('add', [
			'as' => 'location.type.add', 'uses' => 'LocationTypeController@addView',
		]);

		Route::get('edit/{id}', [
			'as' => 'location.type.edit', 'uses' => 'LocationTypeController@editView',
		]);

		Route::get('list', [
			'as' => 'location.type.list', 'uses' => 'LocationTypeController@listView',
		]);

		Route::get('json/list', [
			'as' => 'location.type.list', 'uses' => 'LocationTypeController@jsonList',
		]);

		/**
		 * POST Routes
		 */
		Route::post('add', [
			'as' => 'location.type.add', 'uses' => 'LocationTypeController@add',
		]);

		Route::post('edit/{id}', [
			'as' => 'location.type.edit', 'uses' => 'LocationTypeController@edit',
		]);

		Route::post('status', [
			'as' => 'location.type.status', 'uses' => 'LocationTypeController@status',
		]);

	});
});