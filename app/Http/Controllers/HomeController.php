<?php
/**
 * Created by PhpStorm.
 * User: Greabock
 * Date: 30.08.2016
 * Time: 20:11
 */

namespace App\Http\Controllers;


use Illuminate\Contracts\View\Factory;

class HomeController
{
    public function index(Factory $view){
        return $view->make('app.home');
    }
}