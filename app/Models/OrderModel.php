<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{

    protected string $table = 'orders';

    public function getOrders($shopName) : array
    {
        return $this->db->table($this->table)
            ->select('*')
            ->limit(20)
            ->orderBy('id', 'desc')
            ->where(['store' => $shopName])
            ->get()->getResult();
    }

    public function changeStatus($orderId, $status)
    {
        $this->db->table($this->table)->where(['orderId' => $orderId])->update(['status' => $status]);
    }

    public function getById($orderId)
    {
        return $this->db->table($this->table)
            ->select('*')
            ->limit(1)
            ->where(['orderId' => $orderId])
            ->get()->getRow();
    }

    public function getShopId($orderId)
    {
        return $this->db->table($this->table)
            ->select('shops.id')
            ->limit(1)
            ->join('shops', 'shops.name = orders.store')
            ->where(['orderId' => $orderId])
            ->get()->getRow()->id;
    }

}