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
	Route::group(['prefix' => 'audit', 'namespace' => 'Sammy\AuditManage\Http\Controllers'], function () {
		/**
		 * GET Routes
		 */
		Route::get('asset/list', [
			'as' => 'audit.asset.list', 'uses' => 'AssetAuditController@listView',
		]);

		Route::post('asset/list', [
			'as' => 'audit.asset.list', 'uses' => 'AssetAuditController@printAll',
		]);


	});
});