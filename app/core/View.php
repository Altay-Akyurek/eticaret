<?php
namespace App\Core;

class View
{
    public static function render($view, $params = [])
    {
        extract($params);
        include __DIR__ . '/../Views/' . $view . '.php';
    }
}
