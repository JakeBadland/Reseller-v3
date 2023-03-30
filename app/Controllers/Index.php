<?php

namespace App\Controllers;

class Index extends BaseController
{

    public function __construct()
    {

    }

    public function index($param = null) : string
    {
        if  (!$param) {
            $param = 1;
        }

        $db = \Config\Database::connect();

        $shops = $db->table('shops')->get()->getResultArray();
        $apiUrl = $db->table('settings')->select('value')->getWhere(['key' => 'PROM_API_URL'])->getRowArray(0)['value'];
        $shopInfo = $db->table('shops')->select('*')->getWhere(['id' => $param])->getRowArray(0);

        $prom = new \App\Libraries\LibProm($apiUrl, $shopInfo['token']);
        $parser = new \App\Helpers\OrderParser();

        $orders = $prom->getOrders(0, 20);

        $result = [];
        foreach ($orders as $order){
            $result[] = $parser::parseOrder($order, $shopInfo['name']);
        }

        $data = [
            'orders' => $result,
            'shops' => $shops,
            'color' => $shopInfo['color']
        ];

        return view('content',  $data);
    }

    public function test()
    {
        $addr = 'смт Чемерівці (Хмельницька обл.), 31601, пров. Поштовий, 1А';

        $result = preg_match_all("/\d{5}/", $addr,$out, PREG_PATTERN_ORDER);

        if ($result){
            return 'Укрпочта ' . $out[0][0];
        }

        return '';
    }
}
