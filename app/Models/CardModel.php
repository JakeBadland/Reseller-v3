<?php

namespace App\Models;

use App\Libraries\LibBcrypt;
use CodeIgniter\Model;

class CardModel extends Model
{

    protected string $table = 'cards';

    public function getById($cardId)
    {
        return $this->db->table($this->table)->select('*')->getWhere(['id' => $cardId])->getRow();
    }

    public function addCard($data)
    {
        $this->db->table($this->table)->insert($data);
    }

    public function updateCard($data)
    {
        $cardId = $data['id'];
        unset($data['id']);

        $this->db->table($this->table)->set($data)->where('id', $cardId)->update();
    }

    public function getCardId($cardName)
    {
        return $this->db->table($this->table)->select('*')->getWhere(['name' => $cardName])->get()->Row();
    }

    public function getCardBalance($cardId)
    {
        return $this->db->table($this->table)
            ->select('*')
            ->where(['id' => $cardId])
            ->get()->getRow()->current_balance;
    }
}