<?php

namespace App\Models;

use CodeIgniter\Model;

class AnomalyModel extends Model
{

    protected string $table = 'anomalies';

    public function addAnomaly($name, $lat, $lon, $level = 1, $type = 'RADIOACTIVE')
    {
        /*
        $query = "INSERT INTO {$this->table} (name, $lat, $lon, level, type)
        VALUES ('$name', POINT($location), $level, '$type')";
        $query = $this->db->query($query);
        */
        //return $query->getRow();
    }

    public function saveAnomaly($data)
    {
        $this->db->table($this->table)->insert($data);
    }

    public function getAll() : array
    {
        return $this->db->table($this->table)->select('*')->get()->getResult();
    }

}