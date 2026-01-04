<?php
/**
 * CHECK-IN/CHECK-OUT MANAGEMENT ROUTES
 *
 * @version 1.0.0
 * @author sriya <csriyarathne@gmail.com>
 * @copyright 2015 Yasith Samarawickrama
 */

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix' => 'check-inout', 'namespace' => 'Sammy\CheckInout\Http\Controllers'], function () {
		/**
		 * GET Routes
		 */
		Route::get('checkin', [
			'as' => 'checkInout.checkin', 'uses' => 'CheckInoutController@checkinView',
		]);

		Route::get('checkin/details/{id}', [
			'as' => 'checkInout.checkin', 'uses' => 'CheckInoutController@checkinDetailsView',
		]);

		Route::get('checkout', [
			'as' => 'checkInout.checkout', 'uses' => 'CheckInoutController@checkoutView',
		]);

		Route::get('getAssets', [
			'as' => 'checkInout.checkout', 'uses' => 'CheckInoutController@getAssets',
		]);

		Route::get('reject', [
			'as' => 'checkInout.reject', 'uses' => 'CheckInoutController@rejectListView',
		]);

		Route::get('reject/details/{id}', [
			'as' => 'checkInout.reject', 'uses' => 'CheckInoutController@rejectDetailView',
		]);

		/************ something unknown ************/
        
        Route::get('json/get-assets', [
            'as' => 'checkInout.checkin', 'uses' => 'CheckInoutController@getAssetList',
        ]);

		Route::get('checkit', [
			'as' => 'checkInout.checkit', 'uses' => 'CheckInoutController@checkitView',
		]);
		
		Route::get('get-device', [
			'as' => 'checkInout.get-device', 'uses' => 'CheckInoutController@getDevice',
		]);

		Route::get('json/load-bucket-data', [
			'as' => 'checkInout.load-bucket-data', 'uses' => 'CheckInoutController@loadBucketData',
		]);

		Route::get('asset-list', [
			'as' => 'checkInout.asset-list', 'uses' => 'CheckInoutController@assetList',
		]);

		Route::get('get-pending-assets', [
			'as' => 'checkInout.get-pending-assets', 'uses' => 'CheckInoutController@getPendingAssets',
		]);

		/************** issue note ***************/

		Route::get('issuenote/list', [
			'as' => 'checkInout.issuenote.list', 'uses' => 'CheckInoutController@issuenoteListView',
		]);

		Route::get('issuenote/details/{id}', [
			'as' => 'checkInout.issuenote.list', 'uses' => 'CheckInoutController@issuenoteDetails',
		]);

		Route::get('print/issuenote/{id}', [
			'as' => 'checkInout.issuenote.print', 'uses' => 'CheckInoutController@issueNotePrint',
		]);

		/************** GRN ***************/

		Route::get('grn/list', [
			'as' => 'checkInout.grn.list', 'uses' => 'CheckInoutController@grnListView',
		]);

        Route::get('grn/details/{id}', [
			'as' => 'checkInout.grn.list', 'uses' => 'CheckInoutController@grnDetailsView',
		]);

		Route::get('print/grn/{id}', [
			'as' => 'checkInout.grn.print', 'uses' => 'CheckInoutController@grnPrint',
		]);


		/**
		 * POST Routes
		 */

		Route::post('checkout', [
			'as' => 'checkInout.checkout', 'uses' => 'CheckInoutController@checkout',
		]);

        Route::post('json/load-assets', [
            'as' => 'checkInout.checkin', 'uses' => 'CheckInoutController@loadAssets',
        ]);

        Route::post('json/check-in', [
            'as' => 'checkInout.checkin', 'uses' => 'CheckInoutController@checkin',
        ]);

        Route::post('json/reject', [
            'as' => 'checkInout.checkin', 'uses' => 'CheckInoutController@reject',
        ]);
	});
});