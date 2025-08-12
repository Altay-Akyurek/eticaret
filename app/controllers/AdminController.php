<?php
namespace app\Controllers;

use App\Core\View;
use App\Models\ProductModel;
use App\Models\UserModel;


class AdminController
{
    public function dashboard() 
    {
        //yetki kortrolü eklenmeli!
        $productModel=new ProductModel();
        $userModel = new UserModel();
        $products=$productModel->getAll();
        $users = $userModel->getAll();
        View::render("admin/dashboard",["products"=>$products,"users"=>$users]);

    }
    public function products()
    {
        $productModel=new ProductModel();
        $products=$productModel->getAll();
        View::render("admin/product",["products"=>$products]);  
    }
}
?>