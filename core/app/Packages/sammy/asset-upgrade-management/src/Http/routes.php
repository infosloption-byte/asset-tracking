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
	Route::group(['prefix' => 'asset/upgrade', 'namespace' => 'Sammy\AssetUpgradeManage\Http\Controllers'], function () {
		/**
		 * GET Routes
		 */
		Route::get('add/{id}', [
			'as' => 'asset.upgrade.add', 'uses' => 'AssetUpgradeController@addView',
		]);

		Route::get('history/{id}', [
			'as' => 'asset.upgrade.history', 'uses' => 'AssetUpgradeController@historyView',
		]);

		/**
		 * POST Routes
		 */
		Route::post('add/{id}', [
			'as' => 'asset.upgrade.add', 'uses' => 'AssetUpgradeController@add',
		]);

		Route::post('unassign', [
			'as' => 'asset.upgrade.unassign', 'uses' => 'AssetUpgradeController@unassignAsset',
		]);


	});
});