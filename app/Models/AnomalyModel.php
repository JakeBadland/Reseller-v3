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

    public function getAll($activeOnly = true) : array
    {
        $query = $this->db->table($this->table)
            ->select('*');

        if ($activeOnly){
            $query->where(['is_active' => 1]);
        }

        return $query->get()
        ->getResult();
    }

}