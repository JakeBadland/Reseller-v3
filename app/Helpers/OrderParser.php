<?php

namespace App\Helpers;

const PRICE_TYPE = 'налож*';

class OrderParser{

    public static function parseOrder($order, $shopName)
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
        $result->id = $order->id;

        $result->description = '';
        $result->purchaseType = self::parsePurchaseType($order->payment_option);
        $result->price = self::parsePrice($result->purchaseType, $order->full_price);
        $result->status = $order->status;

        $result->system = 'S_OK';

        /*
        $description1 = '';
        $description2 = '';
        */

        return $result;

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

    private static function parsePurchaseType($paymentOption) : ?string
    {
        if (!isset($paymentOption->name)){
            return null;
        }

        switch ($paymentOption->name){
            case 'На карту "Приват Банка"': {return 'БАНК*';}
            case 'Наложенный платеж': { return 'налож*';}
            default: return null;
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
                return 'Новая почта ' . self::getDelivery($deliveryAddress);
            }
            case 'ukrposhta':{
                return $deliveryAddress;
            }
            default: {
                return 'Warning! delivery address can`t be identified!';
            }
        }
    }

    private static function getDelivery($addr)
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

        return $result;
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