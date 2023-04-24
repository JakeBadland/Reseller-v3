<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Dna extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $user = new UserModel();
        $user = $user->get();

        $errors = [];

        if (!$user){
            $errors[] = 'You don`t have permission to access this page';
        }

        if ($errors){
            return view('errors/error', [
                'errors' => $errors,
            ]);
        }


    }

    public function users()
    {
        $db = db_connect();
        $users = $db->table('users')
            ->select('*')
            ->join('roles', 'users.role = roles.id')
            //->where(['users.id != 1'])
            ->get()
            ->getResult();
        $roles = $db->table('roles')->select('*')->get()->getResult();

        foreach ($users as $key => $user){
            if ($user->id == 1){
                //unset($users[$user->id]); - не используй)
                unset($users[$key]); //проще так) Хотя в верхнем случае "по идее должно сработать"
            }
        }

        return view('dna/users', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function roles()
    {

    }

    public function shops()
    {

    }

    public function items()
    {

    }

    public function addUser()
    {
        $data = $this->request->getPost();

        $errors = [];

        if (empty($data['login'])){
            $errors[] = 'Login can`t be empty';
        }

        if (empty($data['password'])){
            $errors[] = 'Password can`t be empty';
        }

        if (empty($data['confirm'])){
            $errors[] = 'Password confirm can`t be empty';
        }

        if ($data['password'] != $data['confirm']){
            $errors[] = 'Passwords doe`s not match';
        }

        if ($errors){
            return view('errors/error', [
                'errors' => $errors,
            ]);
        }

        $user = new UserModel();
        $user->addUser($data);
    }

    public function editUser($userId = null)
    {
        $db = db_connect();

        $data = $this->request->getPost();

        if ($data){
            //update user
            //redirect to users
        }

        $roles = $db->table('roles')->select('*')->get()->getResult();

        $user = new UserModel();
        $userData = $user->getById($userId);

        return view('dna/edit_user', [
            'roles' => $roles,
            'user' => $userData
        ]);
    }

}