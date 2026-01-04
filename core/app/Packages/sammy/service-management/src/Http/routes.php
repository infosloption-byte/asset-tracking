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
    Route::group(['prefix' => 'service', 'namespace' => 'Sammy\ServiceManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'service.add', 'uses' => 'ServiceController@addView'
      ]);

      Route::get('edit/{id}', [
        'as' => 'service.edit', 'uses' => 'ServiceController@editView'
      ]);

      Route::get('view/{id}', [
        'as' => 'service.details', 'uses' => 'ServiceController@detailView'
      ]);

      Route::get('print/{id}', [
        'as' => 'service.print', 'uses' => 'ServiceController@printView'
      ]);

      Route::get('list', [
        'as' => 'service.list', 'uses' => 'ServiceController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'service.list', 'uses' => 'ServiceController@jsonList'
      ]);

      Route::get('json/start_service', [
        'as' => 'service.list', 'uses' => 'ServiceController@startService'
      ]);

      Route::get('json/complete_service', [
        'as' => 'service.list', 'uses' => 'ServiceController@completeService'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'service.add', 'uses' => 'ServiceController@add'
      ]);

      Route::post('edit/{id}', [
        'as' => 'service.edit', 'uses' => 'ServiceController@edit'
      ]);

      Route::post('delete', [
        'as' => 'service.delete', 'uses' => 'ServiceController@delete'
      ]);
  });     
});