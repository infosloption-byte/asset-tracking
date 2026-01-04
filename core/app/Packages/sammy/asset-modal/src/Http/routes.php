<?php
/**
 * CATEGORY MANAGEMENT ROUTES
 *
 * @version 1.0.0
 * @author sriya <csriyarathne@gmail.com>
 * @copyright 2015 Yasith Samarawickrama
 */

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix' => 'asset-modal', 'namespace' => 'Sammy\AssetModal\Http\Controllers'], function () {
		/**
		 * GET Routes
		 */
		Route::get('add', [
			'as' => 'asset-modal.add', 'uses' => 'AssetModalController@addView',
		]);

		Route::get('edit/{id}', [
			'as' => 'asset-modal.edit', 'uses' => 'AssetModalController@editView',
		]);

		Route::get('list', [
			'as' => 'asset-modal.list', 'uses' => 'AssetModalController@listView',
		]);

		Route::get('json/list', [
			'as' => 'asset-modal.list', 'uses' => 'AssetModalController@jsonList',
		]);

		Route::get('json/get-device-field', [
			'as' => 'asset-modal.list', 'uses' => 'AssetModalController@getDeviceField',
		]);

		/**
		 * POST Routes
		 */
		Route::post('add', [
			'as' => 'asset-modal.add', 'uses' => 'AssetModalController@add',
		]);

		Route::post('edit/{id}', [
			'as' => 'asset-modal.edit', 'uses' => 'AssetModalController@edit',
		]);

        Route::post('delete', [
            'as' => 'asset-modal.delete', 'uses' => 'AssetModalController@delete'
        ]);

        Route::post('status', [
            'as' => 'asset-modal.status', 'uses' => 'AssetModalController@status'
        ]);

	});
});