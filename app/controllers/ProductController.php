<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Core\View;

class ProductController
{
	public function index()
	{
		$model = new ProductModel();
		$products = $model->getAll();
		View::render('products', ['products' => $products]);
	}

	public function detail($id)
	{
		$model = new ProductModel();
		$product = $model->getById($id);
		View::render('product_detail', ['product' => $product]);
	}
}
?>