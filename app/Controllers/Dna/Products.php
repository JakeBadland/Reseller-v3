<?php

namespace App\Controllers\Dna;

use App\Controllers\BaseController;
use App\Models\CardModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\RedirectResponse;

class Products extends BaseController
{

    public function index() : string
    {
        $db = db_connect();
        $model = new ProductModel();
        $products = $model->getAll(100);

        return view('dna/products', [
            'products' => $products,
        ]);

    }


}