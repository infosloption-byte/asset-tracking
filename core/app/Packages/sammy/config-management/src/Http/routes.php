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
    Route::group(['prefix' => 'config', 'namespace' => 'Sammy\ConfigManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      
      Route::get('/add', [
        'as' => 'config.add', 'uses' => 'ConfigController@configView'
      ]);

      /**
       * POST Routes
       */
      
      Route::post('/add', [
        'as' => 'config.add', 'uses' => 'ConfigController@addConfig'
      ]);

    });
});