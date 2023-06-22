<?php

namespace App\Controllers;

use App\Models\CardModel;
use App\Models\RuleModel;
use App\Models\UserModel;


class Index extends BaseController
{

    public function index($param = null) : string
    {
        $user = new UserModel();
        $user = $user->get();

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

        $prom = new \App\Libraries\LibProm($apiUrl, $shopInfo['token']);
        $parser = new \App\Helpers\OrderParser();

        $orders = $prom->getOrders(0, 20);

        $result = [];
        foreach ($orders as $order){
            $parser::saveOrder($order, $shopInfo['shop_name']);
            $result[] = $parser::parseOrder($order, $shopInfo['shop_name']);
        }

        $data = [
            'orders'    => $result,
            'shops'     => $shops,
            'shop_info' => $shopInfo,
            'color'     => $shopInfo['color'],
            'user'      => $user
        ];

        return view('content',  $data);
    }

    public function viber($orderId, $cardId) : string
    {
        $cardsModel = new CardModel();


        $db = db_connect();

        $order = $db->table('orders')->select('*')->where(['orderId' => $orderId])->get()->getRow();
        $card = $cardsModel->getById($cardId);

        switch ($order->purchaseType){
            case 'БАНК*': {
                $key = 'TEMPLATE_FULL';
            }
                break;
            case 'налож*': {
                $key = 'TEMPLATE_PREPAID';
            }
                break;
            default : {
                $key = null;
            }
        }

        //$shop = $db->table('shops')->select('*')->where(['name' => $order->store])->get()->getRowArray();

        $template = $db->table('settings')->select('value')->where(['key' => $key])->get()->getRow()->value;

        $bankPercent = 0.5;
        $percent = $order->finalPrice / 100 * $bankPercent;

        $params = [
            '%FIRST_NAME%'  => $order->name,
            '%MARKET%'      => $order->store,
            '%PAY_DAY%'     => "<label id='pay_day_label' style='font-weight: 200;'>завтра</label>",
            '%PAY_PERCENT%' => $order->prepaid,
            '%BANK%'        => "{$card->bank} {$card->number} {$card->name}",
            '%SUM1%'        => $order->finalPrice,
            '%BANK_PERCENT%'=> $bankPercent.'%',
            '%SUM2%'        => round($order->finalPrice + $percent),
            '%SALE_ID%'     => $orderId,
            '%DELIVERY_DAY%'=> "<label id='delivery_day_label' style='font-weight: 200;'>завтра</label>",
        ];

        foreach ($params as $key => $param){
            $template = str_replace($key, $param, $template);
        }

        $template = nl2br($template);

        return view('viber', [
            'order' => $order,
            'template' => $template
        ]);
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
    }

    public function test()
    {
        $sum = (int) '3536';



        echo "<PRE>";
        var_dump($sum);
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
