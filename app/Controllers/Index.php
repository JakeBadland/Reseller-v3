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
            ->select('*, shops.name as shop_name, shops.id as shop_id')
            ->get()->getResultArray();

        $apiUrl = $db->table('settings')->select('value')->getWhere(['key' => 'PROM_API_URL'])->getRowArray(0)['value'];
        $shopInfo = $db->table('shops')
            ->select('*, shops.name as shop_name')
            ->getWhere(['shops.id' => $param])
            ->getRowArray(0);

        /*
        $rule = null;
        $ruleCards = null;
        $rule = $db->table('rules')->select('*')->where(['shop_id' => $param])->get()->getResult();
        if ($rule){
            $rule = $rule[0];
            $ruleCards = $db->table('cards_to_rules')
                ->select('*')
                ->join('cards', 'cards.id = cards_to_rules.card_id')
                ->where(['rule_id' => $rule->id])
                ->get()->getResult();
        }
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
            'color' => $shopInfo['color'],
            //'rule' => $rule
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
        echo "<PRE>";
        var_dump(\Yii::$app->db->getLastInsertID());
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
