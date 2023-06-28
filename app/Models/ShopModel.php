<?php

namespace App\Models;

use CodeIgniter\Model;

class ShopModel extends Model
{

    public $shop;
    protected $db;
    protected string $table = 'shops';

    public function getById($shopId)
    {
        return $this->db->table($this->table)->select('*')->getWhere(['id' => $shopId])->getRow(0);
    }

    public function addShop($data)
    {
        $this->db->table($this->table)->insert($data);
    }

    public function updateShop($data){
        $shopId = $data['id'];
        unset($data['id']);

        $this->db->table($this->table)->set($data)->where('id', $shopId)->update();
    }

    public function getForParse()
    {
        return $this->db->table($this->table)
            ->select('*')
            ->limit(1)
            ->orderBy('parsed_at', 'asc')
            ->get()->getRowArray();
    }



}