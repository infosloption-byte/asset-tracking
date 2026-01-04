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
    Route::group(['prefix' => 'category', 'namespace' => 'Sammy\CategoryManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'category.add', 'uses' => 'CategoryController@addView'
      ]);

      Route::get('edit/{id}', [
        'as' => 'category.edit', 'uses' => 'CategoryController@editView'
      ]);

      Route::get('list', [
        'as' => 'category.list', 'uses' => 'CategoryController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'category.list', 'uses' => 'CategoryController@jsonList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'category.add', 'uses' => 'CategoryController@add'
      ]);

      Route::post('edit/{id}', [
        'as' => 'category.edit', 'uses' => 'CategoryController@edit'
      ]);

      Route::post('delete', [
        'as' => 'category.delete', 'uses' => 'CategoryController@delete'
      ]);

      Route::post('status', [
        'as' => 'category.status', 'uses' => 'CategoryController@status'
      ]);
  });     
});