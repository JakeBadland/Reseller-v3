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

    public function index() : string
    {
        $libProm = new LibProm('https://my.prom.ua', '0bdfa79dd84a89d0ce54e02eed6a212d38c20e9b');

        //$result = $libProm->getOrders(0, 20);

        /*
        $result = $libProm->getOrderById(248207660);
        echo "<PRE>";
        var_dump($result->order->status);
        echo "</PRE>";
        die;
        */

        // [ pending, received, delivered, canceled, draft, paid ]

        $result = $libProm->changeStatus(248207660, 'delivered');

        echo "<PRE>";
        var_dump($result);
        echo "</PRE>";

    }

}
