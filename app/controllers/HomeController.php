<?php
namespace app\Controllers;

use app\core\View;

class HomeController
{
    public function index()
    {
        View::render('home');
    }
    
}
?>