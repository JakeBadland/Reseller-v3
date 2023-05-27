<?php

namespace App\Models;

use App\Libraries\LibBcrypt;
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

        $card = new CardModel();

        $data['card_id'] = $card->getCardId($data['card']);

        unset($data['card']);

        $this->db->table('shops')->set($data)->where('id', $shopId)->update();
    }



}