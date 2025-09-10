<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\ProductModel;

class HomeController
{
    public function index()
    {
        $productModel = new ProductModel();
        $products = $productModel->getAll();

        View::render('home', [
            'title'    => 'Anasayfa',
            'products' => $products,
        ]);
    }
}
