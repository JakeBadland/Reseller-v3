<?php

namespace App\Controllers\Game;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{

    public function login()
    {
        $user = new UserModel();

        $data = $this->request->getPost();

        if ($data){
            $result = $user->auth($data);

            if ($result){
                return redirect()->to('game');
            } else {
                return view('game/login', ['error' => 'Access denied!']);
            }
        }
    }

}