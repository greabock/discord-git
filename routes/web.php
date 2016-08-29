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

Route::post('hook', function (BaseRequest $request){
    $content = json_encode(json_decode($request->getContent(), true), JSON_PRETTY_PRINT);
    
    File::put(storage_path('hooks/hook_'.time().'.json'), $content);
});