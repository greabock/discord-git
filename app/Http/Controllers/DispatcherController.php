<?php
namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory as View;


/**
 * Class ControllersController
 * @package App\Http\Controllers
 */
class DispatcherController
{
    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @return string
     */
    public function index(){
        return $this->view->make('app.dispatcher');
    }
}