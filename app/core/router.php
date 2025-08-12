<?php
namespace App\Core;

class Router
{
    public static function dispatch()
    {
        $url = $_GET['url'] ?? 'register/store';
        $url = explode('/', filter_var(trim($url, '/'), FILTER_SANITIZE_URL));

        $controllerName = ucfirst($url[0]) . 'Controller';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);

        $controllerPath = __DIR__ . '/../Controllers/' . $controllerName . '.php';
        $controllerClass = '\\App\\Controllers\\' . $controllerName;

        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controller = new $controllerClass();

            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                echo "Fonksiyon bulunamadı.";
            }
        } else {
            echo "Sayfa bulunamadı.";
        }
    }
}
