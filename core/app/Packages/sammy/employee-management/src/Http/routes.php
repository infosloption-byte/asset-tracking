<?php

Route::group(['middleware' => ['auth']], function()
{
    Route::group(['prefix' => 'employee/type', 'namespace' => 'Sammy\EmployeeManage\Http\Controllers'], function(){
        /**
        * GET Routes
        */
        Route::get('add', [
            'as' => 'employee.type.add', 'uses' => 'EmployeeTypeController@addView'
        ]);

        Route::get('list', [
            'as' => 'employee.type.list', 'uses' => 'EmployeeTypeController@listView'
        ]);

        Route::get('json/list', [
            'as' => 'employee.type.list', 'uses' => 'EmployeeTypeController@jsonList'
        ]);

        Route::get('edit/{id}', [
            'as' => 'employee.type.edit', 'uses' => 'EmployeeTypeController@editView'
        ]);

        /**
        * POST Routes
        */
        Route::post('add', [
            'as' => 'employee.type.add', 'uses' => 'EmployeeTypeController@add'
        ]);

        Route::post('delete', [
            'as' => 'employee.type.delete', 'uses' => 'EmployeeTypeController@delete'
        ]);
        
        Route::post('status', [
            'as' => 'employee.type.status', 'uses' => 'EmployeeTypeController@status'
        ]);

        Route::post('edit/{id}', [
            'as' => 'employee.type.edit', 'uses' => 'EmployeeTypeController@edit'
        ]);    

    });

    /**
    *for employee curd
    */

    Route::group(['prefix' => 'employee', 'namespace' => 'Sammy\EmployeeManage\Http\Controllers'], function(){
        /**
        * GET Routes
        */
        Route::get('add', [
            'as' => 'employee.add', 'uses' => 'EmployeeController@addView'
        ]);

        Route::get('list', [
            'as' => 'employee.list', 'uses' => 'EmployeeController@listView'
        ]);

        Route::get('json/list', [
            'as' => 'employee.list', 'uses' => 'EmployeeController@jsonList'
        ]);

        Route::get('edit/{id}', [
            'as' => 'employee.edit', 'uses' => 'EmployeeController@editView'
        ]);

        Route::get('listE/{id?}', [
            'as' => 'employee.edit', 'uses' => 'EmployeeController@getParentList'
        ]);

        Route::get('filter', [
            'as' => 'employee.edit', 'uses' => 'EmployeeController@filter'
        ]);

        Route::get('view', [
            'as' => 'employee.list', 'uses' => 'EmployeeController@getViewData'
        ]);

        Route::get('getLocation', [
            'as' => 'employee.add', 'uses' => 'EmployeeController@getLocation'
        ]);

        Route::get('getParent', [
            'as' => 'employee.add', 'uses' => 'EmployeeController@getParent'
        ]);

        Route::get('getAsset', [
            'as' => 'employee.add', 'uses' => 'EmployeeController@getAsset'
        ]);

        /**
        * POST Routes
        */
        Route::post('add', [
            'as' => 'employee.add', 'uses' => 'EmployeeController@add'
        ]);

        Route::post('delete', [
            'as' => 'employee.delete', 'uses' => 'EmployeeController@delete'
        ]);

        Route::post('edit/{id}', [
            'as' => 'employee.edit', 'uses' => 'EmployeeController@edit'
        ]);

        Route::post('status', [
            'as' => 'employee.status', 'uses' => 'EmployeeController@status'
        ]);

        Route::post('varify', [
            'as' => 'employee.varify', 'uses' => 'EmployeeController@varify'
        ]);

        Route::post('reject', [
            'as' => 'employee.reject', 'uses' => 'EmployeeController@reject'
        ]);

    });

    /**
    *for Reset password
    */

    Route::group(['prefix' => 'employee/reset', 'namespace' => 'Sammy\EmployeeManage\Http\Controllers'], function(){
        /**
        * GET Routes
        */
        Route::get('reset-password', [
            'as' => 'employee.reset.reset-password', 'uses' => 'EmployeeController@viewPasswordReset'
        ]);

        Route::get('load-employee', [
            'as' => 'employee.reset.reset-password', 'uses' => 'EmployeeController@loadEmployee'
        ]);

        Route::get('load-data', [
            'as' => 'employee.reset.reset-password', 'uses' => 'EmployeeController@loadCredentialData'
        ]);

        /**
        * POST Routes
        */
        Route::post('reset-password', [
            'as' => 'employee.reset.reset-password', 'uses' => 'EmployeeController@passwordReset'
        ]);
    });
});