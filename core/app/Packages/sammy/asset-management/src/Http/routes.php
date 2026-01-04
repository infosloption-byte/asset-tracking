<?php
/**
 * ASSET MANAGEMENT ROUTES
 *
 * @version 1.0.0
 * @author Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright 2015 Yasith Samarawickrama
 */

/**
 * ASSET MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function()
{
    Route::group(['prefix' => 'asset', 'namespace' => 'Sammy\AssetManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'asset.add', 'uses' => 'AssetController@addView'
      ]);

      Route::get('view/{id}', [
        'as' => 'asset.view', 'uses' => 'AssetController@detailView'
      ]);

      Route::get('edit/{id}', [
        'as' => 'asset.edit', 'uses' => 'AssetController@editView'
      ]);

      Route::get('list', [
        'as' => 'asset.list', 'uses' => 'AssetController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'asset.list', 'uses' => 'AssetController@jsonList'
      ]);

      Route::get('json/getFieldSet', [
        'as' => 'asset.add', 'uses' => 'AssetController@jsonFields'
      ]);

      Route::get('upload', [
        'as' => 'asset.upload', 'uses' => 'AssetController@uploadAssetView'
      ]);

      Route::get('json/location', [
        'as' => 'asset.upload', 'uses' => 'AssetController@jsonListLocation'
      ]);

      Route::get('json/excel-detail', [
        'as' => 'asset.upload', 'uses' => 'AssetController@jsonListExcelDetail'
      ]);

      Route::get('json/getLocation', [
        'as' => 'asset.add', 'uses' => 'AssetController@getLocation'
      ]);

      Route::get('user/assign', [
        'as' => 'asset.user.assign', 'uses' => 'AssetController@assetAssignView'
      ]);

      Route::get('user/assign/employeeJosnList', [
        'as' => 'asset.user.assign', 'uses' => 'AssetController@getEmployee'
      ]);

      Route::get('checkForDispose', [
        'as' => 'asset.view', 'uses' => 'AssetController@checkForDispose'
      ]);

      Route::get('get-asset-location-employee', [
        'as' => 'asset.list', 'uses' => 'AssetController@getAssetLocationUsers'
      ]);

      Route::get('get-location-employee', [
        'as' => 'asset.list', 'uses' => 'AssetController@getAssetLocationUsers'
      ]);

      Route::get('delete', [
        'as' => 'asset.delete', 'uses' => 'AssetController@assetDeleteView'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'asset.add', 'uses' => 'AssetController@add'
      ]);

      Route::post('upload', [
        'as' => 'asset.upload', 'uses' => 'AssetController@uploadAsset'
      ]);

      Route::post('putToDamage', [
        'as' => 'asset.damage', 'uses' => 'AssetController@putToDamage'
      ]);

      Route::post('edit/{id}', [
        'as' => 'asset.edit', 'uses' => 'AssetController@edit'
      ]);

      Route::post('delete', [
        'as' => 'asset.delete', 'uses' => 'AssetController@delete'
      ]);

      Route::post('user/assign', [
        'as' => 'asset.user.assign', 'uses' => 'AssetController@assetAssign'
      ]);

      Route::post('user/unAssign', [
        'as' => 'asset.user.unassign', 'uses' => 'AssetController@assetUnAssign'
      ]);

      Route::get('set-warranty-period', [
        'as' => 'asset.list', 'uses' => 'AssetController@setWarrantyPeriod'
      ]);

      Route::post('user/assign-bulk', [
        'as' => 'asset.user.assign.bulk', 'uses' => 'AssetController@assetBulkAssign'
      ]);

      Route::post('user/unassign-bulk', [
        'as' => 'asset.user.unassign.bulk', 'uses' => 'AssetController@assetBulkUnAssign'
      ]);

      Route::post('delete', [
        'as' => 'asset.delete', 'uses' => 'AssetController@deleteAssets'
      ]);
  });     
});