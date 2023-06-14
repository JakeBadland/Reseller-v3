<?php

namespace App\Models;

use CodeIgniter\Model;

class RuleModel extends Model
{

    protected string $table = 'rules';
    protected int $cardIndex = 0;

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

    public function getRuleCard($shopInfo, $order, $getFull = false)
    {
        $result = null;

        $rules = $this->db->table('rules')
            ->where(['rules.shop_id' => $shopInfo['id']])
            ->get()->getResult();

        $defaultCard = $this->db->table('cards')
            ->where(['cards.id' => $shopInfo['card_id']])
            ->get()->getRow();

        foreach ($rules as $rule){
            //if enabled and price >= from && <= to
            if ( ((int)$rule->enabled) && ( (int)$order->finalPrice >= (int)$rule->from ) && ( (int)$order->finalPrice <= (int) $rule->to) ){
                //get rule cards
                $cards = $this->db->table('cards_to_rules')
                    ->where(['cards_to_rules.rule_id' => $rule->id])
                    ->join('cards', 'cards_to_rules.card_id = cards.id')
                    ->get()->getResult();

                if (count($cards) > 0) {
                    switch ($rule->type){
                        case 'random' : {
                            $result = $cards[rand(0, count($cards) - 1)];
                        } break;
                        case 'cyclically' : {
                            if ($this->cardIndex > count($cards) - 1) $this->cardIndex = 0;
                            $result = $cards[$this->cardIndex];
                            $this->cardIndex++;
                        } break;
                    }
                }
            }
        }

        if ($getFull){
            if ($result) {
                return $result;
            } else {
                return $defaultCard;
            }
        } else {
            if ($result) {
                return $result->short;
            } else {
                return $defaultCard->short;
            }
        }

    }

}