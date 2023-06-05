<?php

namespace App\Controllers;

use \App\Models\RuleModel;
use \App\Models\UserModel;
use \App\Models\CardModel;
use \App\Models\ShopModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\Input;

class Dna extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $user = new UserModel();
        $user = $user->get();

        if (!$user){
            header('Location: /login');
            die;
        }

        if ($user->role_id != 1){
            header('Location: /login');
            die;
        }

    }

    public function users() : string
    {
        $db = db_connect();
        $users = $db->table('users')
            ->select('*, users.id as user_id')
            ->join('roles', 'users.role_id = roles.id')
            //->where(['users.id != 1'])
            ->get()
            ->getResult();
        $roles = $db->table('roles')->select('*')->get()->getResult();

        return view('dna/users', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function addUser()
    {
        //$db = db_connect();

        $data = $this->request->getPost();

        $errors = [];

        if (empty($data['login'])){
            $errors[] = 'Login can`t be empty';
        }

        if (empty($data['password'])){
            $errors[] = 'Password can`t be empty';
        }

        if (empty($data['confirm'])){
            $errors[] = 'Password confirm can`t be empty';
        }

        if ($data['password'] != $data['confirm']){
            $errors[] = 'Passwords doe`s not match';
        }

        if ($errors){
            return view('errors/error', [
                'errors' => $errors,
            ]);
        }

        $user = new UserModel();
        $user->addUser($data);

        return redirect()->to('dna');
    }

    public function editUser($userId = null)
    {
        $db = db_connect();

        $data = $this->request->getPost();

        $user = new UserModel();

        if ($data){
            $user->updateUser($data);
            return redirect()->to('dna');
        }

        $roles = $db->table('roles')->select('*')->get()->getResult();

        $userData = $user->getById($userId);

        return view('dna/edit_user', [
            'roles' => $roles,
            'user' => $userData
        ]);
    }

    public function deleteUser() : RedirectResponse
    {
        $db = db_connect();

        $data = $this->request->getPost();

        $userId = $data['user_id'];

        $result = $db->table('users')
            ->where(['id' => $userId])
            ->delete();

        return redirect()->to('dna');
    }


    public function cards() : string
    {
        $db = db_connect();
        $cards = $db->table('cards')
            ->select('*,  cards.id as card_id')
            ->get()
            ->getResult();

        return view('dna/cards', [
            'cards' => $cards,
        ]);
    }

    public function editCard($cardId = null)
    {
        $db = db_connect();

        $data = $this->request->getPost();

        $card = new CardModel();

        if ($data){
            $card->updateCard($data);
            return redirect()->to('dna/cards');
        }

        $cardData = $card->getById($cardId);

        return view('dna/edit_card', [
            'card' => $cardData
        ]);
    }

    public function addCard()
    {
        $data = $this->request->getPost();

        $errors = [];

        if (empty($data['name'])){
            $errors[] = 'Name can`t be empty';
        }

        if (empty($data['number'])){
            $errors[] = 'Number can`t be empty';
        }

        if ($errors){
            return view('errors/error', [
                'errors' => $errors,
            ]);
        }

        $card = new CardModel();
        $card->addCard($data);

        return redirect()->to('dna/cards');
    }

    public function deleteCard() : RedirectResponse
    {
        $db = db_connect();

        $data = $this->request->getPost();

        $cardId = $data['card_id'];

        $result = $db->table('cards')
            ->where(['id' => $cardId])
            ->delete();

        return redirect()->to('dna/cards');
    }

    public function shops() : string
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

        return redirect()->to('dna/shops');
    }

    public function rules() : string
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

    /*
    public function addRule()
    {
        $data = $this->request->getPost();

        $data['from'] = (int) $data['from'];
        $data['to'] = (int) $data['to'];
        $data['enabled'] = (int) $data['enabled'];
        $data['shop_id'] = (int) $data['shop_id'];
        $data['current_card'] = 0;

        $cards = $data['cards'];
        unset($data['cards']);

        $ruleModel = new RuleModel();
        $ruleId = $ruleModel->addRule($data);

        foreach ($cards as $cardId){
            $ruleModel->addRuleCard($cardId, $ruleId);
        }
    }

    public function updateRule()
    {
        $db = db_connect();

        $data = $this->request->getPost();

        $data['from'] = (int) $data['from'];
        $data['to'] = (int) $data['to'];
        $data['enabled'] = (int) $data['enabled'];
        $shopId = (int) $data['shop_id'];
        $ruleId = (int) $data['rule_id'];
        $cards = $data['cards'];

        unset($data['rule_id']);
        unset($data['cards']);

        $ruleModel = new RuleModel();
        $ruleModel->updateRule($data, $ruleId);

        $db->table('cards_to_rules')
            ->where(['rule_id' => $ruleId])
            ->delete();

        foreach ($cards as $cardId){
            $ruleModel->addRuleCard($cardId, $ruleId);
        }

    }
    */


}