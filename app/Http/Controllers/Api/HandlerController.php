<?php

namespace App\Http\Controllers\Api;


use App\Handler;
use App\Http\Requests\StoreHandlerRequest;

class HandlerController
{
    public function index()
    {
        $data = Handler::with('routes')->get();

        return response()->json(compact('data'));
    }

    public function store(StoreHandlerRequest $request, Handler $handler)
    {
        $handler->fill($request->all())->save();
        $handler->routes()->sync($request->get('routes'));

        $handler->load('routes');
        return response(['data' => $handler], 201);
    }

    public function destroy($id, Handler $handler){
        $handler = $handler->find($id);
        $handler->delete();

        return response(null, 204);
    }
}