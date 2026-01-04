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
    Route::group(['prefix' => 'manufacturer', 'namespace' => 'Sammy\ManufacturerManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'manufacturer.add', 'uses' => 'ManufacturersController@addView'
      ]);

      Route::get('edit/{id}', [
        'as' => 'manufacturer.edit', 'uses' => 'ManufacturersController@editView'
      ]);

      Route::get('list', [
        'as' => 'manufacturer.list', 'uses' => 'ManufacturersController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'manufacturer.list', 'uses' => 'ManufacturersController@jsonList'
      ]);

      Route::get('trash', [
        'as' => 'manufacturer.trash', 'uses' => 'ManufacturersController@trashListView'
      ]);

      Route::get('json/trash_list', [
         'as' => 'manufacturer.trash', 'uses' => 'ManufacturersController@jsonTrashList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'manufacturer.add', 'uses' => 'ManufacturersController@add'
      ]);

      Route::post('edit/{id}', [
        'as' => 'manufacturer.edit', 'uses' => 'ManufacturersController@edit'
      ]);

      Route::post('status', [
        'as' => 'manufacturer.status', 'uses' => 'ManufacturersController@status'
      ]);

      Route::post('delete', [
        'as' => 'manufacturer.delete', 'uses' => 'ManufacturersController@delete'
      ]);

      Route::post('restore', [
         'as' => 'manufacturer.trash', 'uses' => 'ManufacturersController@restore'
      ]);
    });
});