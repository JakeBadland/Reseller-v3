<?php

namespace App\Models;

use App\Libraries\LibBcrypt;
use CodeIgniter\Model;

class RadioModel extends Model
{

    protected string $table = 'radio';

    public function getById($itemId)
    {
        return $this->db->table($this->table)->select('*')->getWhere(['id' => $itemId])->getRow();
    }

    public function addStation($data)
    {
        $this->db->table($this->table)->insert($data);
    }

    public function radioUp($itemId)
    {
        $this->db->table($this->table)
            ->set('views', 'views + 1', FALSE)
            ->where('id', $itemId)
            ->update();
    }

    public function updateStation($data)
    {
        $itemId = $data['id'];
        unset($data['id']);

        $this->db->table($this->table)->set($data)->where('id', $itemId)->update();
    }

    public function getStationId($itemName)
    {
        return $this->db->table($this->table)->select('*')->getWhere(['name' => $itemName])->get()->Row();
    }

    public function getAll()
    {
        return $this->db
            ->table($this->table)
            ->select('*')
            ->orderBy('views', 'desc')
            ->get()->getResult();
    }

}