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

        /*
        $anomaly = new AnomalyModel();
        $data = [
            'id'            => uniqid(),
            'name'          => 'test_loc',
            'lat'           => 50.48455,
            'lon'           => 30.49469,
            'level'         => 1,
            'force'         => 1,
            'radius'        => 20,
            'interval'      => 10,
            'type_id'       => 2,
            'created_at'    => date('Y-m-d H:i:s')
        ];

        $anomaly->saveAnomaly($data);
        */

        return view('game/game', [
            'user'  => $user
        ]);
    }

    public function getAnomalies()
    {
        $anomaModel = new AnomalyModel();
        $anomalies = $anomaModel->getAll(true);

        echo json_encode($anomalies);
    }

    public function saveUserLoc()
    {
        $userModel = new UserModel();
        $user = $userModel->get();

        $data = $this->request->getPost();
        $data = $data['data'];

        $data['last_action'] = date('Y-m-d H:i:s');

        echo "<PRE>";
        var_dump($data);
        echo "</PRE>";

        $userModel->updateGameInfo($user->id, $data);
    }

    public function login() : string
    {
        return view('game/login');
    }


}