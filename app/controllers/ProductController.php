<?php
namespace app\Controllers;

use app\models\ProductModel;
use app\core\View;

class ProductController
{
    public function index()
    {
    $model =new ProductModel();
    $products=$model->getAll();
    View::render('products',['products'=>$products]);
    }
    public function detail($id)
    {
        $model=new ProductModel();
        $produces=$model->getById($id);
        View::render('product_detail',['product'=>$produces]);
        
    }
}
?>