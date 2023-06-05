<?php

namespace App\Models;

use CodeIgniter\Model;

class RuleModel extends Model
{

    protected string $table = 'rules';

    public function addRule($data) : int
    {
        $this->db->table($this->table)->insert($data);

        return $this->db->insertID();
    }

    public function updateRule($ruleId, $data)
    {
        $this->db->table($this->table)->where(['id' => $ruleId])->update($data);
    }

    public function deleteRule($ruleId)
    {

    }

    public function updateCards($ruleId, $cards)
    {
        $this->db->table('cards_to_rules')
            ->where(['rule_id' => $ruleId])
            ->delete();

        $data['rule_id'] = $ruleId;

        foreach ($cards as $cardId){
            $data['card_id'] = $cardId;
            $this->db->table('cards_to_rules')->insert($data);
        }
    }

    public function getRuleCard($rule, $order)
    {

    }

}