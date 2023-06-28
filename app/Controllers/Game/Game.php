<?php

namespace App\Controllers\Game;

use App\Controllers\BaseController;
use App\Models\AnomalyModel;
use App\Models\UserModel;

class Game extends BaseController
{

    public function index() : string
    {
        $user = new UserModel();
        $user = $user->get();

        $anomaly = new AnomalyModel();

        $data = [
            'id'            => uniqid(),
            'name'          => 'test',
            'lat'           => 50.48455,
            'lon'           => 30.49469,
            'level'         => 1,
            'force'         => 1,
            'radius'        => 20,
            'interval'      => 10,
            'type_id'       => 2,
            'created_at'    => date('Y-m-d H:i:s')
        ];

        //$anomaly->saveAnomaly($data);

        /*
        $anomaly->addAnomaly('first', '50.48455, 30.49469', 1, 'COLD');
        */

        return view('game/game');
    }

    public function saveUserLoc($userId, $location)
    {

    }

    public function login() : string
    {
        return view('game/login');
    }


}