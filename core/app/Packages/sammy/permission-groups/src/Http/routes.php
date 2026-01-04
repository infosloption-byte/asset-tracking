<?php
/**
 * PERMISSION GROUPS ROUTES
 *
 * @version 1.0.0
 * @author aruna wijerathna <arunaswj@gmail.com>
 * @copyright 2015 Aruna Wijerathna
 */

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function(){
	
    Route::group(['prefix' => 'permission/groups', 'namespace' => 'Sammy\PermissionGroups\Http\Controllers'], function(){

      /**
       * GET Routes
       */
      
      Route::get('add', [
          'as'   => 'permission.groups.add', 'uses' => 'PermissionGroupsController@addView'
      ]);// add view of permission groups

      Route::get('list',[
          'as'   => 'permission.groups.list', 'uses' => 'PermissionGroupsController@listView'
      ]);// get permission group list

      Route::get('permission/list',[
          'as'   => 'permission.groups.list', 'uses' => 'PermissionGroupsController@jsonList'
      ]);// get permission group list

      /**
       * POST Routes
       */

      Route::post('add', [
          'as' => 'permission.groups.add', 'uses' => 'PermissionGroupsController@addGroup'
      ]);

    });
});