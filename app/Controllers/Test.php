<?php

namespace App\Controllers;

use App\Libraries\LibProm;
use App\Models\CardModel;
use App\Models\OrderModel;
use App\Models\PromOrder;
use App\Models\ShopModel;
use App\Models\UserModel;


class Test extends BaseController
{

    public function index()
    {
        //phpinfo();
        die('test');


        //Товар Всем
        $libProm = new LibProm('https://my.prom.ua', '14c860ff4745a4d2c005a61eae99e6851bd1871d');

        //Юг Отт
        //$libProm = new LibProm('https://my.prom.ua', '0bdfa79dd84a89d0ce54e02eed6a212d38c20e9b');

        /*
        $result = $libProm->getOrders(0, 20);

        echo "<PRE>";
        var_dump($result);
        echo "</PRE>";
        die;
        */


        $result = $libProm->getOrderById(250380320);

        if ($result){
            echo "<PRE>";
            //var_dump($result->order->status);
            var_dump($result);
            echo "</PRE>";
        }
        //die;



        // [ pending, received, delivered, canceled, draft, paid ]

        $result = $libProm->changeStatus(250380320, 'pending');

        echo "<PRE>";
        var_dump($result);
        echo "</PRE>";

    }

}
