<?php

namespace App\Controllers\Dna;

use App\Controllers\BaseController;
use App\Models\TemplateModel;


class Templates extends BaseController
{

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