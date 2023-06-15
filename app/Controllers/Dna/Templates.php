<?php

namespace App\Controllers\Dna;

use App\Controllers\BaseController;
use App\Models\TemplateModel;
use App\Models\UserModel;
use App\Models\CardModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use Psr\Log\LoggerInterface;

class Templates extends BaseController
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
        $templates = new TemplateModel();
        $templates = $templates->getAll();

        return view('dna/templates', [
            'templates' => $templates,
        ]);
    }

    public function editTemplate($templateId = null)
    {
        $templates = new TemplateModel();
        $template = $templates->getById($templateId);

        $data = $this->request->getPost();
        if ($data){
            $templates->updateTemplate($data);
            return redirect()->to('dna/templates');
        }

        return view('dna/edit_template', [
            'template' => $template
        ]);
    }

}