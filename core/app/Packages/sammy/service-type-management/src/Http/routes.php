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
    Route::group(['prefix' => 'service/type', 'namespace' => 'Sammy\ServiceTypeManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'service_type.add', 'uses' => 'ServiceTypeController@addView'
      ]);

      Route::get('edit/{id}', [
        'as' => 'service_type.edit', 'uses' => 'ServiceTypeController@editView'
      ]);

      Route::get('list', [
        'as' => 'service_type.list', 'uses' => 'ServiceTypeController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'service_type.list', 'uses' => 'ServiceTypeController@jsonList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'service_type.add', 'uses' => 'ServiceTypeController@add'
      ]);

      Route::post('edit/{id}', [
        'as' => 'service_type.edit', 'uses' => 'ServiceTypeController@edit'
      ]);

      Route::post('delete', [
        'as' => 'service_type.delete', 'uses' => 'ServiceTypeController@delete'
      ]);

      Route::post('status', [
        'as' => 'service_type.status', 'uses' => 'ServiceTypeController@status'
      ]);
  });     
});