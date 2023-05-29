<?php

namespace App\Controllers;

use \App\Models\UserModel;

class Index extends BaseController
{

    public function __construct()
    {
        //$this->request = \Config\Services::request();
    }

    public function index($param = null) : string
    {
        if  (!$param) {
            $param = 1;
        }

        $db = db_connect();

        $shops = $db->table('shops')
            ->select('*, cards.name as card_name, cards.id as card_id, shops.name as shop_name, shops.id as shop_id')
            ->join('cards', 'shops.card_id = cards.id')
            ->get()
            ->getResultArray();

        $apiUrl = $db->table('settings')->select('value')->getWhere(['key' => 'PROM_API_URL'])->getRowArray(0)['value'];
        $shopInfo = $db->table('shops')
            ->select('*, shops.name as shop_name')
            ->join('cards', 'shops.card_id = cards.id')
            ->getWhere(['shops.id' => $param])
            ->getRowArray(0);

        /*
        $shops = $db->table('shops')
            ->select('*,  shops.id as shop_id, shops.name as shop_name, cards.name as card_name')
            ->join('cards', 'shops.card_id = cards.id')
            ->get()
            ->getResult();
        */

        $prom = new \App\Libraries\LibProm($apiUrl, $shopInfo['token']);
        $parser = new \App\Helpers\OrderParser();

        $orders = $prom->getOrders(0, 20);

        $result = [];
        foreach ($orders as $order){
            $result[] = $parser::parseOrder($order, $shopInfo['shop_name']);
        }

        $data = [
            'orders' => $result,
            'shops' => $shops,
            'shop_info' => $shopInfo,
            'color' => $shopInfo['color']
        ];

        return view('content',  $data);
    }

    public function login()
    {
        $user = new UserModel();

        $data = $this->request->getPost();

        if ($data){
            $result = $user->auth($data);

            if ($result){
                return redirect()->to('dna');
            }
        }

        return view('login');
    }

    public function logout()
    {
        $user = new UserModel();
        $user->logout();

        header('Location: /login');
        die;
        /*
        return redirect()->to('/');
        */
    }

    public function test()
    {
        $user = new UserModel();
        $user = $user->get();

        echo "<PRE>";
        var_dump($user);
        echo "</PRE>";

        /*
        $bcrypt = new \App\Libraries\LibBcrypt();

        $password = '';
        echo "<PRE>";
        var_dump($password);
        echo "</PRE>";
        $hash = $bcrypt->hash_password($password);

        echo "<PRE>";
        var_dump($hash);
        echo "</PRE>";

        die;
        */

    }

}
