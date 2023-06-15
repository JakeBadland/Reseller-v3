<?php

namespace App\Models;

use CodeIgniter\Model;

class TemplateModel extends Model
{

    protected string $table = 'settings';

    public function getAll()
    {
        return $this->db->table($this->table)
            ->select('*')
            ->where(['key' => 'TEMPLATE_PREPAID'])
            ->orWhere(['key' => 'TEMPLATE_FULL'])
            ->get()->getResult();
    }

    public function getById($templateId)
    {
        return $this->db->table($this->table)
            ->select('*')
            ->where(['id' => $templateId])
            ->get()->getRow();
    }

    public function updateTemplate($data){
        $templateId = $data['id'];
        unset($data['id']);

        $this->db->table($this->table)->set($data)->where('id', $templateId)->update();
    }



}