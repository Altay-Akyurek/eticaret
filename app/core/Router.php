<?php
namespace App\Core;

class Router
{
    public static function dispatch()
    {
        $url = $_GET['url'] ?? '';
        $url = explode('/', filter_var(trim($url, '/'), FILTER_SANITIZE_URL));

        // Varsayılan değerler
        $controllerName = ucfirst($url[0] ?? 'home') . 'Controller';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);

        // Admin login/logout için özel yönlendirme
        if (($url[0] ?? '') === 'admin' && in_array($url[1] ?? '', ['login', 'logout'])) {
            $controllerName = 'AdminAuthController';
        }

        $controllerPath = __DIR__ . '/../Controllers/' . $controllerName . '.php';
        $controllerClass = '\\App\\Controllers\\' . $controllerName;

        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controller = new $controllerClass();

            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                echo "Fonksiyon bulunamadı. Controller: {$controllerName}, Method: {$method}";
            }
        } else {
            echo "Sayfa bulunamadı. Controller dosyası: {$controllerPath}";
        }
    }
}
?>