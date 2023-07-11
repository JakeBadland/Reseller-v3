<?php

namespace App\Helpers;

use App\Models\ProductModel;
use App\Models\PromOrder;

const PRICE_TYPE = 'налож*';

class OrderParser{

    protected string $table = 'orders';

    public static function parseOrder($order, $shopName) : PromOrder
    {
        $result = new \App\Models\PromOrder();

        $date = strtotime($order->date_created);
        $date = date('d.m.Y', $date);

        $result->store = $shopName;
        $result->name = trim($order->client_first_name) . ' ' . trim($order->client_last_name);
        $result->phone = trim($order->phone, '+');
        $result->address = self::parseAddress($order->delivery_address, $order->delivery_provider_data);

        $result->deliveryProvider = self::parseDelivery($order->delivery_address, $order->delivery_provider_data);
        $result->date = $date;
        $result->orderId = $order->id;

        $result->description = '';
        $result->purchaseType = self::parsePurchaseType($order->payment_option);
        $result->price = self::parsePrice($result->purchaseType, $order->full_price);
        $result->finalPrice = self::getFinalPrice($result->purchaseType, $order->full_price);
        $result->prepaid = self::getPrepaid($result->purchaseType, $order->full_price);

        $result->status = $order->status;

        //$result->system = 'S_OK';

        /*
        $description1 = '';
        $description2 = '';
        */

        return $result;

    }

    public static function saveOrder($order, $shopName)
    {
        $db = db_connect();
        $productModel = new ProductModel();
        $products = $order->products;

        $order = self::parseOrder($order, $shopName);
        $isExist = $db->table('orders')->select('*')->where(['orderId' => $order->orderId])->get()->getRow();

        $shopId = $db->table('shops')->select('id')->where(['name' => $shopName])->get()->getRow()->id;

        $order->created_at = date('Y-m-d H:i:s');

        if (!$isExist){
            $db->table('orders')->insert($order);
            $productModel->saveProducts($shopId, $db->insertID(), $products);
        } else {
            $db->table('orders')->where(['orderId' => $order->orderId])->update(['status' => $order->status]);
        }

    }

    private static function getPrepaid($type, $price)
    {
        $price = preg_replace('/[^0-9]/', '', $price);

        if ($type == PRICE_TYPE){
            $percent = $price / 10;
            return (int) round($percent, -2);
        } else {
            return '';
        }

    }

    private static function parsePrice($type, $price)
    {
        $price = preg_replace('/[^0-9]/', '', $price);

        if ($type == PRICE_TYPE){
            $percent = $price / 10;
            $temp = round($percent, -2);
            $result = $price - $temp;
            return  "$price - $temp = $result";
        } else {
            return $price;
        }
    }

    private static function getFinalPrice($type, $price)
    {
        $price = preg_replace('/[^0-9]/', '', $price);

        if ($type == PRICE_TYPE){
            $percent = $price / 10;
            $temp = round($percent, -2);
            $result = $price - $temp;
            return  "$result";
        } else {
            return $price;
        }
    }

    private static function parsePurchaseType($paymentOption) : ?string
    {
        if (!isset($paymentOption->name)){
            return '';
        }

        switch ($paymentOption->name){
            case 'На карту "Приват Банка"': {return 'БАНК*';}
            case 'На карту Приват Банка': {return 'БАНК*';}
            case 'Безналичный расчет на карту банка Приват.': {return 'БАНК*';}
            case 'Безналичный расчет на карту Приват Банка': {return 'БАНК*';}
            case 'Наложенный платеж': { return 'налож*';}
            default: {

            }
        }

    }

    private static function parseDelivery($deliveryAddress, $deliveryData) : ?string
    {

        if (!isset($deliveryData->provider)){
            return '$deliveryData->provider not set';
            //return '';
        }

        switch ($deliveryData->provider){
            case 'nova_poshta' : {
                return self::getDeliveryNovaPoshta($deliveryAddress);
            }
            case 'ukrposhta':{
                return self::getDeliveryUrkPoshta($deliveryAddress);
            }
            default: {
                return 'Warning! delivery address can`t be identified!';
            }
        }
    }

    private static function getDeliveryNovaPoshta($addr) : string
    {
        $pattern = "/№(?P<digit>\d+)/";
        preg_match_all($pattern, $addr,$out, PREG_PATTERN_ORDER);

        $result = (!empty($out[0][0])) ? $out[0][0]: null;

        if (!$result){
            $pattern = "/№\s(?P<digit>\d+)/";
            preg_match_all($pattern, $addr,$out, PREG_PATTERN_ORDER);

            $result = (!empty($out[0][0])) ? $out[0][0]: '';
            $result = str_replace(' ', '', $result);
        };

        return 'Новая почта ' . $result;

    }

    private static function getDeliveryUrkPoshta($addr) : string
    {
        $result = preg_match_all("/\d{5}/", $addr,$out, PREG_PATTERN_ORDER);

        if ($result){
            return 'Укрпочта ' . $out[0][0];
        }

        return '';

    }

    private static function parseAddress($deliveryAddress, $deliveryData) : ?string
    {
        if (!isset($deliveryData->provider)){
            return '';
        }

        switch ($deliveryData->provider){
            case 'nova_poshta' : {
                return self::parseNovaPoshta($deliveryAddress);
            }
            case 'ukrposhta':{
                return $deliveryAddress;
            }
            default: return '';
        }
    }

    private static function parseNovaPoshta($address) : ?string
    {
        return $address;
    }

}