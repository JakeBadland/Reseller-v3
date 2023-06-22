<?php

namespace App\Controllers\Dna;

use App\Controllers\BaseController;
use App\Models\ShopModel;
use CodeIgniter\HTTP\RedirectResponse;

class Shops extends BaseController
{

    public function index() : string
    {
        $db = db_connect();
        $shops = $db->table('shops')
            ->select('*,  shops.id as shop_id, shops.name as shop_name, cards.name as card_name, cards.id as card_id')
            ->join('cards', 'shops.card_id = cards.id')
            ->get()
            ->getResult();

        $cards = $db->table('cards')->select('*')->get()->getResult();

        return view('dna/shops', [
            'shops' => $shops,
            'cards' => $cards
        ]);
    }

    public function editShop($shopId = null)
    {
        $db = db_connect();

        $data = $this->request->getPost();

        $shop = new shopModel();

        if ($data){
            $shop->updateShop($data);
            return redirect()->to('dna/shops');
        }

        $ruleCards = null;

        $cards = $db->table('cards')->select('*')->get()->getResult();
        $rule = $db->table('rules')->select('*')->where(['shop_id' => $shopId])->get()->getResult();
        if ($rule) {
            $rule = $rule[0];
            $ruleCards = $db->table('cards_to_rules')
                ->select('*')
                ->join('cards', 'cards.id = cards_to_rules.card_id')
                ->where(['rule_id' => $rule->id])
                ->get()->getResult();
        }
        $shopData = $shop->getById($shopId);

        return view('dna/edit_shop', [
            'shop' => $shopData,
            'cards' => $cards,
            'rule' => $rule,
            'rule_cards' => $ruleCards
        ]);
    }

    public function addShop()
    {
        $data = $this->request->getPost();

        $errors = [];

        if (empty($data['name'])){
            $errors[] = 'Name can`t be empty';
        }

        if (empty($data['token'])){
            $errors[] = 'Token can`t be empty';
        }

        if (empty($data['color'])){
            $errors[] = 'Color can`t be empty';
        }

        if ($errors){
            return view('errors/error', [
                'errors' => $errors,
            ]);
        }

        $card = new ShopModel();
        $card->addShop($data);

        return redirect()->to('dna/shops');
    }

    public function deleteShop() : RedirectResponse
    {
        $db = db_connect();

        $data = $this->request->getPost();

        $shopId = $data['shop_id'];

        $rule = $db->table('rules')->select('*')->where(['shop_id' => $shopId])->get()->getResult();
        if ($rule) {
            $rule = $rule[0];

            $db->table('cards_to_rules')
                ->where(['rule_id' => $rule->id])
                ->delete();

            $db->table('rules')
                ->where(['id' => $rule->id])
                ->delete();
        }

        $db->table('shops')
            ->where(['id' => $shopId])
            ->delete();

        return redirect()->to('dna/shops');
    }

}