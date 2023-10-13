<?php

namespace App\Controllers;

use App\Helpers\OrderParser;
use App\Libraries\LibProm;
use App\Models\ShopModel;

class Cron extends BaseController
{

    public function c24hour()
    {
        $db = db_connect();

        $cards = $db->table('cards')
            ->select('cards.*')
            ->groupBy('id')
        //    ->set(['cards.current_balance' => 0])
            ->join('cards_to_rules', 'cards_to_rules.card_id = cards.id')
            ->join('rules', 'rules.id = cards_to_rules.rule_id')
            ->where([
                'rules.is_enabled' => 1,
                'cards.auto_clear' => 1
            ])
            //->update();
            ->get()->getResult();

        $ids = [];
        foreach ($cards as $card){
            $ids[] = $card->id;
        }

        $db->table('cards')->set(['current_balance' => 0])->whereIn('id', $ids)->update();
    }

    public function c2min()
    {
        $db = db_connect();

        //Cron::log('Started at: ' . date('Y-m-d H:i:s'));

        $shopModel = new ShopModel();
        $shopInfo = $shopModel->getForParse();

        $shopInfo['parsed_at'] = date('Y-m-d H:i:s');
        //$shopModel->updateShop($shopInfo);

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

        die('done');
    }

    private static function log($message)
    {
        $fileName = 'log_' . date('Y-m-d') . '.log';
        file_put_contents($fileName, $message);
    }



}
