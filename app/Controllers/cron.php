<?php

namespace App\Controllers;

use App\Helpers\OrderParser;
use App\Libraries\LibProm;
use App\Models\ShopModel;

class Cron extends BaseController
{

    public function c2min()
    {
        $db = db_connect();

        $shopModel = new ShopModel();
        $shopInfo = $shopModel->getForParse();

        $shopInfo['parsed_at'] = date('Y-m-d H:i:s');
        $shopModel->updateShop($shopInfo);

        $apiUrl = $db->table('settings')
            ->select('value')
            ->getWhere(['key' => 'PROM_API_URL'])
            ->getRowArray(0)['value'];

        $prom = new LibProm($apiUrl, $shopInfo['token']);
        $parser = new OrderParser();

        $orders = $prom->getOrders(0, 20);

        foreach ($orders as $order){
            $parser::saveOrder($order, $shopInfo['name']);
        }
    }



}
