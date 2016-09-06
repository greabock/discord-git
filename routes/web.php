<?php


Route::group(['middleware' => 'web'], function (){
    Route::get('/', [
        'as'   => 'home',
        'uses' => 'HomeController@index',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Auth routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [
            'as'   => 'auth.login',
            'uses' => 'Auth\LoginController@login',
        ]);
        Route::get('handle', [
            'as'   => 'auth.handle',
            'uses' => 'Auth\LoginController@handle',
        ]);
    });

    Route::get('logout', [
        'as'   => 'auth.logout',
        'uses' => 'Auth\LoginController@logout',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Dispatcher routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'dispatcher', 'middleware' => 'auth'], function () {
        Route::get('/', [
            'as'   => 'dispatcher',
            'uses' => 'DispatcherController@index',
        ]);

        Route::group(['prefix' => 'routes', ], function (){
            Route::get('/', 'Api\RouteController@index');
            Route::post('/', 'Api\RouteController@store');
            Route::put('{id}', 'Api\RouteController@update');
            Route::delete('{id}', 'Api\RouteController@destroy');
        });

        Route::group(['prefix' => 'guilds', ], function (){
            Route::get('/' , 'Api\GuildController@index');
        });

        Route::group(['prefix' => 'handlers'], function (){
            Route::get('/', 'Api\HandlerController@index');
            Route::post('/', 'Api\HandlerController@store');
            Route::delete('{id}', 'Api\HandlerController@destroy');
        });
    });
});

Route::group(['middleware' => 'throttle:60,1'], function (){
    Route::post('hook/{hook}', 'Api\HookController@handle');
});








