<?php
/**
 * REQUEST MANAGEMENT ROUTES
 *
 * @version 1.0.0
 * @author sriya <csriyarathne@gmail.com>
 * @copyright 2015 Yasith Samarawickrama
 */

/**
 * REQUEST MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix' => 'request', 'namespace' => 'Sammy\RequestManage\Http\Controllers'], function () {
		/**
		 * GET Routes
		 */
		Route::get('add', [
			'as' => 'request.add', 'uses' => 'RequestManageController@addView',
		]);

		Route::get('edit/{id}', [
			'as' => 'request.edit', 'uses' => 'RequestManageController@editView',
		]);

		Route::get('list', [
			'as' => 'request.list', 'uses' => 'RequestManageController@listView',
		]);

		Route::get('json/list', [
			'as' => 'request.list', 'uses' => 'RequestManageController@jsonList',
		]);

		Route::get('getAsset', [
			'as' => 'request.list', 'uses' => 'RequestManageController@getAsset',
		]);

		Route::get('checkSoftwareAsset', [
			'as' => 'request.list', 'uses' => 'RequestManageController@checkSoftwareAsset',
		]);

		/**
		 * POST Routes
		 */
		Route::post('add', [
			'as' => 'request.add', 'uses' => 'RequestManageController@add',
		]);

		Route::post('edit/{id}', [
			'as' => 'request.edit', 'uses' => 'RequestManageController@edit',
		]);

        Route::post('reject', [
            'as' => 'request.reject', 'uses' => 'RequestManageController@rejectRequest'
        ]);

        Route::post('approve', [
            'as' => 'request.approve', 'uses' => 'RequestManageController@approveRequest'
        ]);

        Route::post('replace', [
            'as' => 'request.approve', 'uses' => 'RequestManageController@setReplacementDetail'
        ]);

        Route::post('sent-to-service', [
            'as' => 'request.sent-to-service', 'uses' => 'RequestManageController@sentToService'
        ]);
	});
});