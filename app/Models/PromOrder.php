<?php

namespace App\Models;

class PromOrder {

    public $store = ''; //A название магазина
    public $name;       //B имя пользователя
    public $phone;      //C номер телефона
    public $address;    //D адресс доставки
    public $date;       //E дата заказа из прома
    public $id;         //F номер заказа
    public $price;      //G сумма заказа
    public $deliveryProvider; //H сервис доставки

    public $description;//I [пустая строка]
    public $purchaseType;//J тип оплаты
    public $description1 = ''; //K
    public $description2 = ''; //L

    public $prepaid;

    public $status;
    public $system = '';

}