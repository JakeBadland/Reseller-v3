<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{

    protected string $table = 'products';

    public function getAll($limit = null)
    {

        /*
        return $this->db->table($this->table)
            ->select('*')
            ->where(['key' => 'TEMPLATE_PREPAID'])
            ->orWhere(['key' => 'TEMPLATE_FULL'])
            ->get()->getResult();
        */
    }

    public function saveProducts($shopId, $orderId, $products)
    {
        foreach ($products as $product){
            $product = $this->parseProduct($shopId, $orderId, $product);
            $this->saveProduct($product);
        }
    }

    public function saveProduct($product)
    {
        if ($this->isExist($product['prom_id'])){

            $dbProduct = $this->db->table($this->table)->select('*')
                ->where(['prom_id' => $product['prom_id']])
                ->get()->getRow();

            $data = ['count' => $dbProduct->count + $product['count']];

            $this->db->table($this->table)->where(['id' => $dbProduct->id])->update($data);
        } else {
            $this->db->table($this->table)->insert($product);
        }
    }

    public function parseProduct($shopId, $orderId, $data)
    {

        return [
            'shop_id'       => (int) $shopId,
            'order_id'      => (int) $orderId,
            'count'         => (int) $data->quantity,
            'prom_id'       => (int) $data->id,
            'external_id'   => (int) $data->external_id,
            'name'          => $data->name,
            'price'         => (int) $data->price,
            'img'           => $data->image,
            'url'           => $data->url,
            'created_at'    => date('Y-m-d H:i:s')
        ];

    }

    public function isExist($promId)
    {
        return (bool)$this->db->table($this->table)
            ->select('*')
            ->where(['prom_id' => $promId])
            ->get()->getResult();
    }

    public function getById($templateId)
    {
        return $this->db->table($this->table)
            ->select('*')
            ->where(['id' => $templateId])
            ->get()->getRow();
    }

}