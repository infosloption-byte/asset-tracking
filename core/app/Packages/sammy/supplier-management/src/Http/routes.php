<?php
/**
 * manufacturer management ROUTES
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
    Route::group(['prefix' => 'supplier', 'namespace' => 'Sammy\SupplierManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'supplier.add', 'uses' => 'SupplierController@addView'
      ]);

      Route::get('edit/{id}', [
        'as' => 'supplier.edit', 'uses' => 'SupplierController@editView'
      ]);

      Route::get('list', [
        'as' => 'supplier.list', 'uses' => 'SupplierController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'supplier.list', 'uses' => 'SupplierController@jsonList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'supplier.add', 'uses' => 'SupplierController@add'
      ]);

      Route::post('edit/{id}', [
        'as' => 'supplier.edit', 'uses' => 'SupplierController@edit'
      ]);

      Route::post('delete', [
        'as' => 'supplier.delete', 'uses' => 'SupplierController@delete'
      ]);

      Route::post('status', [
        'as' => 'supplier.status', 'uses' => 'SupplierController@status'
      ]);

    });
});