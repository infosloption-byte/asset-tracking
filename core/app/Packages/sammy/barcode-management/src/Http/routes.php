<?php
/**
 * service management ROUTES
 *
 * @version 1.0.0
 * @author Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright 2015 Yasith Samarawickrama
 */

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function()
{
    Route::group(['prefix' => 'barcode', 'namespace' => 'Sammy\BarcodeManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('list', [
        'as' => 'barcode.list', 'uses' => 'BarcodeController@listView'
      ]);

      Route::get('print/{id}', [
        'as' => 'barcode.print', 'uses' => 'BarcodeController@printView'
      ]);

      Route::get('bulk/print', [
        'as' => 'barcode.bulk.print', 'uses' => 'BarcodeController@bulkPrintView'
      ]);

      /**
       * POST Routes
       */
      Route::post('generate', [
         'as' => 'barcode.genarate', 'uses' => 'BarcodeController@genarateBarcode'
      ]);

      Route::post('bulk/print', [
        'as' => 'barcode.bulk.print', 'uses' => 'BarcodeController@printBulk'
      ]);

    });
});