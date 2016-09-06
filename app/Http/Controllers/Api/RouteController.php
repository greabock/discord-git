<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreRouteRequest;
use App\Route;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Str;

class RouteController
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * Возвращает список принадлежащих пользователю маршрутов.
     *
     * @param Guard $guard
     *
     * @return mixed
     */
    public function index(Guard $guard)
    {
        return $guard->user()->routes;
    }

    /**
     * Сохраняет маршрут.
     *
     * @param StoreRouteRequest $request
     * @param Guard              $guard
     *
     * @return Route
     */
    public function store(StoreRouteRequest $request, Guard $guard)
    {
        $route = new Route([
            'name' => $request->get('name'),
            'hook' => Str::random(40),
        ]);

        $guard->user()->routes()->save($route);

        return $route;
    }

    /**
     * Обновляет данные маршрута.
     *
     * @param $id
     */
    public function update($id)
    {
    }

    /**
     * Удаляет маршрут.
     *
     * @param Guard $guard
     * @param       $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Guard $guard, $id)
    {
        $route = $guard->user()->routes()->where('id', $id)->first();
        $route->delete();

        return response('', 204);
    }
}