<?php

use Illuminate\Http\Request as BaseRequest;
use NotificationChannels\Discord\Discord;

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


Route::post('hook', function (BaseRequest $request,  Discord $discord){
    $data = json_decode($request->getContent(), true);
    $content = $data['head_commit']['url'];
    $content .= "\n". $data['head_commit']['committer']['name'];
    $discord->send('219876734240161793', compact('content'));
});


