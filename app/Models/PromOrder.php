<?php

namespace App\Models;

use CodeIgniter\Model;

class PromOrder {

    public string $store = ''; //A название магазина
    public string $name;       //B имя пользователя
    public string $phone;      //C номер телефона
    public string $address;    //D адресс доставки
    public string $date;       //E дата заказа из прома
    public string $orderId;    //F номер заказа
    public string $price;      //G сумма заказа
    public string $finalPrice; //финальная сумма
    public string $deliveryProvider; //H сервис доставки
    public $created_at;

    public string $description;//I [пустая строка]
    public string $purchaseType;//J тип оплаты
    public string $description1 = ''; //K
    public string $description2 = ''; //L
    public string $prepaid;
    public string $status;


}