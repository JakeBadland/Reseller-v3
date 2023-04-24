<?php

namespace App\Models;

use CodeIgniter\Model;
use \App\Libraries\LibBcrypt;

class UserModel extends Model{

    public $user;
    protected $db;

    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
    }

    public function auth($data) : bool
    {
        $bcrypt = new LibBcrypt();

        $user = $this->db->table('users')->select('*')->getWhere(['login' => $data['login']])->getRow();

        $result = $bcrypt->check_password($data['password'], $user->password);

        if ($result && !$this->user){
            $this->user = $user;
            $this->saveSession();
        }

        return (bool) $result;
    }

    public function logout()
    {
        if ($this->user){
            $user = $this->get();
            $this->db->table('users')->where(['id' => $user->id])->set(['token' => null])->update();
        }
    }

    public function get()
    {
        $session = \Config\Services::session();

        if (!$this->user){
            $token = $session->get('uToken');

            if (!$token) return null;

            $this->user = $this->db->table('users')->select('*')->getWhere(['token' => $token])->getRow(0);

            if (!$this->user){
                return null;
            }
        }

        return $this->user;
    }

    private function saveSession()
    {
        $session = \Config\Services::session();

        $userToken = uniqid('', true);

        $data = ['token' => $userToken];

        $this->db->table('users')->where(['id' => $this->user->id])->set($data)->update();
        $session->set('uToken', $userToken);
    }

    public function load($data)
    {
        $this->user->id = $data->id;
        $this->user->login = $data->login;
        $this->user->password = $data->password;
        $this->user->email = $data->email;
    }

    public function addUser($data)
    {
        $bcrypt = new LibBcrypt();

        $data['role'] = $this->getRoleId($data['role']);
        unset($data['confirm']);

        $data['password'] = $bcrypt->hash_password($data['password']);
        $this->db->table('users')->insert($data);
    }

    public function getRoleId($roleName)
    {
        return $this->db->table('roles')->select('*')->getWhere(['name' => $roleName])->getRow(0)->id;
    }

    public function getById($userId)
    {
        return $this->db->table('users')->select('*')->getWhere(['id' => $userId])->getRow(0);
    }
}