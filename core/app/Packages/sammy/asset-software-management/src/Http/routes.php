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
    Route::group(['prefix' => 'software', 'namespace' => 'Sammy\AssetSoftwareManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('license/add', [
        'as' => 'software.license.add', 'uses' => 'LicenseController@addView'
      ]);

      Route::get('license/list', [
         'as' => 'software.license.list', 'uses' => 'LicenseController@listView'
      ]);

      Route::get('license/assign/{id}', [
          'as' => 'software.license.assign', 'uses' => 'LicenseController@assignView'
      ]);

      Route::get('license/details/{id}', [
          'as' => 'software.license.assign', 'uses' => 'LicenseController@detailsView'
      ]);

      Route::get('license/getAsset/{license}', [
          'as' => 'software.license.assign', 'uses' => 'LicenseController@getAsset'
      ]);


      /**
       * POST Routes
       */
      Route::post('license/add', [
        'as' => 'software.license.add', 'uses' => 'LicenseController@add'
      ]);

      Route::post('license/assign/{id}', [
         'as' => 'software.license.assign', 'uses' => 'LicenseController@assign'
      ]);

      Route::post('license/unassign', [
         'as' => 'software.license.unassign', 'uses' => 'LicenseController@unAssign'
      ]);

    });

    Route::group(['prefix' => 'software/type', 'namespace' => 'Sammy\AssetSoftwareManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'software_type.add', 'uses' => 'SoftwareTypeController@addView'
      ]);

      Route::get('edit/{id}', [
        'as' => 'software_type.edit', 'uses' => 'SoftwareTypeController@editView'
      ]);

      Route::get('list', [
        'as' => 'software_type.list', 'uses' => 'SoftwareTypeController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'software_type.list', 'uses' => 'SoftwareTypeController@jsonList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'software_type.add', 'uses' => 'SoftwareTypeController@add'
      ]);

      Route::post('edit/{id}', [
        'as' => 'software_type.edit', 'uses' => 'SoftwareTypeController@edit'
      ]);

      Route::post('delete', [
        'as' => 'software_type.delete', 'uses' => 'SoftwareTypeController@delete'
      ]);

      Route::post('status', [
        'as' => 'software_type.status', 'uses' => 'SoftwareTypeController@status'
      ]);

    });
});