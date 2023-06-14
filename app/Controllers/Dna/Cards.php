<?php

namespace App\Controllers\Dna;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\CardModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Cards extends BaseController
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

    public function index() : string
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

}