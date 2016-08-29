<?php

use Illuminate\Http\Request as BaseRequest;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('hook', function (BaseRequest $request){
    $content = $request->getContent();
    File::put(storage_path('hooks/hook_'.time().'.json'), $content);
});