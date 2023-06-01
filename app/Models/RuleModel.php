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

    public function updateRule($data)
    {
        $this->db->table($this->table)->update($data);
    }

    public function addRuleCard($cardId, $ruleId)
    {
        $data['card_id'] = $cardId;
        $data['rule_id'] = $ruleId;
        $this->db->table('cards_to_rules')->insert($data);
    }

}