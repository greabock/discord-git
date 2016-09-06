<?php

namespace App\Http\Controllers\Api;

use App\Handler;
use App\Jobs\SendHook;
use App\Route;
use Illuminate\Http\Request;

class HookController
{
    public function handle(Request $request, $hook)
    {
        $route = Route::with('handlers')->where('hook', $hook)->first();
        if(is_null($route)){
            return response()->isNotFound();
        }

        foreach ($route->handlers as $handler){
            dispatch(new SendHook($handler, $request->getContent()));
        }

        return response('OK', 202);
    }
}