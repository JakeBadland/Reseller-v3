<?php

namespace App\Controllers\Game;

use App\Controllers\BaseController;

class Game extends BaseController
{

    public function index() : string
    {
        return view('game/game');
    }

    public function login() : string
    {
        return view('game/login');
    }


}