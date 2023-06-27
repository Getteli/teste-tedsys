<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Controller para a página principal
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     **/
    public function home()
    {
        return view('home');
    }
}