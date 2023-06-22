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

    public function loadProduct($shopId, $orderId, $data)
    {
        $product = new ProductModel();

        //$product->shop_id =
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