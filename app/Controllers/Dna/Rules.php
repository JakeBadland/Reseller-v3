<?php

namespace App\Controllers\Dna;

use App\Controllers\BaseController;
use \App\Models\RuleModel;
use CodeIgniter\HTTP\RedirectResponse;

class Rules extends BaseController
{

    public function index() : string
    {
        $db = db_connect();
        $rules = $db->table('rules')
            ->select('*, rules.name as rule_name, shops.name as shop_name, rules.id as rule_id, shops.id as shop_id')
            ->join('shops', 'rules.shop_id = shops.id')
            ->get()->getResult();
        $shops = $db->table('shops')->select('*')->get()->getResult();

        return view('dna/rules', [
            'rules' => $rules,
            'shops' => $shops
        ]);
    }

    public function addRule()
    {
        $data = $this->request->getPost();

        $data['type'] = strtolower($data['type']);
        $data['enabled'] = 1;

        $rule = new RuleModel();
        $rule->addRule($data);

        return redirect()->to('dna/rules');
    }

    public function editRule($ruleId = null)
    {
        $db = db_connect();

        $data = $this->request->getPost();

        if ($data){
            $data['enabled'] = (isset($data['enabled']))?  1 : 0;
            $ruleCards = explode(',' , trim($data['rule_cards'], ','));

            $ruleId = $data['id'];

            unset($data['id']);
            unset($data['rule_cards']);

            $rule = new RuleModel();
            $rule->updateCards($ruleId, $ruleCards);
            $rule->updateRule($ruleId, $data);

            return redirect()->to('dna/rules');
        }

        $rule = $db->table('rules')->select('*')->where(['id' => $ruleId])->get()->getRow();
        $cards = $db->table('cards_to_rules')
            ->select('*, ')
            ->join('cards', 'cards_to_rules.card_id = cards.id')
            ->where(['rule_id' => $ruleId])->get()->getResult();
        $allCards = $db->table('cards')->select('*')->get()->getResult();
        $shops = $db->table('shops')->select('*')->get()->getResult();

        return view('dna/edit_rule', [
            'rule' => $rule,
            'shops' => $shops,
            'rule_cards' => $cards,
            'cards' => $allCards
        ]);
    }

    public function deleteRule() : RedirectResponse
    {
        $db = db_connect();

        $data = $this->request->getPost();

        $ruleId = (int) $data['rule_id'];

        $db->table('cards_to_rules')
            ->where(['rule_id' => $ruleId])
            ->delete();

        $db->table('rules')
            ->where(['id' => $ruleId])
            ->delete();

        return redirect()->to('dna/rules');
    }

}