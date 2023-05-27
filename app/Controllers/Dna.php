<?php

namespace App\Controllers;

use \App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use Psr\Log\LoggerInterface;

class Dna extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $user = new UserModel();
        $user = $user->get();

        if (!$user){
            header('Location: /login');
            die;

            //return redirect()->to('login');

            /*
            $errors = [];
            $errors[] = 'You don`t have permission to access this page';
            return view('errors/error', [
                'errors' => $errors,
            ]);
            */
        }

        if ($user->role_id != 1){
            header('Location: /login');
            die;
        }

        /*
        echo "<PRE>";
        var_dump($user->role_id);
        var_dump($user->getRoleName($user->role_id));
        echo "</PRE>";
        */
    }

    public function users()
    {
        $db = db_connect();
        $users = $db->table('users')
            ->select('*, users.id as user_id')
            ->join('roles', 'users.role_id = roles.id')
            //->where(['users.id != 1'])
            ->get()
            ->getResult();
        $roles = $db->table('roles')->select('*')->get()->getResult();

        /*
        foreach ($users as $key => $user){
            if ($user->id == 1){
                //unset($users[$user->id]); - не используй)
                //unset($users[$key]); //проще так) Хотя в верхнем случае "по идее должно сработать"
            }
        }
        */

        return view('dna/users', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function roles()
    {

    }

    public function cards()
    {

    }

    public function items()
    {

    }

    public function addUser()
    {
        $db = db_connect();

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

        return redirect()->to('dna');
    }

    public function editUser($userId = null)
    {
        $db = db_connect();

        $data = $this->request->getPost();

        $user = new UserModel();

        if ($data){
            $user->updateUser($data);
            return redirect()->to('dna');
        }

        $roles = $db->table('roles')->select('*')->get()->getResult();

        $userData = $user->getById($userId);

        return view('dna/edit_user', [
            'roles' => $roles,
            'user' => $userData
        ]);
    }

    public function deleteUser(){
        $db = db_connect();

        $data = $this->request->getPost();

        $userId = $data['user_id'];

        $result = $db->table('users')
            ->where(['id' => $userId])
            ->delete();

        return redirect()->to('dna');
    }

}