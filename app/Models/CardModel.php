<?php

namespace App\Models;

use App\Libraries\LibBcrypt;
use CodeIgniter\Model;

class CardModel extends Model
{

    public $card;
    protected $db;

    public function getById($cardId)
    {
        return $this->db->table('cards')->select('*')->getWhere(['id' => $cardId])->getRow(0);
    }

    public function addCard($data)
    {
        $this->db->table('cards')->insert($data);
    }

    public function updateCard($data){
        $cardId = $data['id'];
        unset($data['id']);

        $this->db->table('cards')->set($data)->where('id', $cardId)->update();
    }

}