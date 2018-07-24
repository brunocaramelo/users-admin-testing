<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1'], function () 
{
    Route::group(['prefix' => 'users'], function () 
    {
        Route::get('/',
                        [ 'as' => 'users-list', 
                        'uses' => '\Admin\User\Controllers\UserController@listAll' 
                    ]);

    });

    Route::group(['prefix' => 'user'], function () 
    {
        Route::post('/',
                            [ 'as' => 'create-user', 
                            'uses' => '\Admin\User\Controllers\UserController@create' 
                            ]);
        Route::get('/{id}',
                            [ 'as' => 'view-user', 
                            'uses' => '\Admin\User\Controllers\UserController@findById' 
                            ]);

        Route::put('/{id}',
                            [ 'as' => 'update-user', 
                            'uses' => '\Admin\User\Controllers\UserController@update' 
                            ]);

        Route::delete('/{id}',
                            [ 'as' => 'delete-user', 
                            'uses' => '\Admin\User\Controllers\UserController@remove' 
                            ]);

    });

});
    