<?php
namespace App\Core;

class Route
{
    /** @var array<string,array<string,mixed>> */
    private static $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => [],
    ];

    /**
     * Register a GET route
     * @param string $path
     * @param callable|string $handler
     */
    public static function get($path, $handler)
    {
        self::add('GET', $path, $handler);
    }

    /**
     * Register a POST route
     * @param string $path
     * @param callable|string $handler
     */
    public static function post($path, $handler)
    {
        self::add('POST', $path, $handler);
    }

    /**
     * Generic add
     * @param string $method
     * @param string $path
     * @param callable|string $handler
     */
    public static function add($method, $path, $handler)
    {
        $method = strtoupper($method);
        $pattern = self::convertPathToRegex($path);
        self::$routes[$method][$pattern] = [
            'handler' => $handler,
            'path' => $path,
        ];
    }

    /**
     * Dispatch a request. Returns true if handled, false otherwise.
     * @param string $method
     * @param string $path
     * @return bool
     */
    public static function dispatch($method, $path)
    {
        $method = strtoupper($method);
        $routesForMethod = self::$routes[$method] ?? [];

        foreach ($routesForMethod as $regex => $info) {
            $params = [];
            if (preg_match($regex, $path, $matches)) {
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $params[$key] = $value;
                    }
                }
                self::invokeHandler($info['handler'], $params);
                return true;
            }
        }
        return false;
    }

    /**
     * Convert a path like /product/detail/{id} into a regex with named captures
     * @param string $path
     * @return string
     */
    private static function convertPathToRegex($path)
    {
        $escaped = preg_replace('#/#', '\\/', trim($path)) ?: '';
        if ($escaped === '' || $escaped === '/') {
            return '#^\/?$#';
        }
        $pattern = preg_replace('#\\/\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '\\/(?P<$1>[^\/]+)', '\/' . $escaped);
        return '#^' . $pattern . '$#';
    }

    /**
     * @param callable|string $handler
     * @param array<string,string> $params
     */
    private static function invokeHandler($handler, array $params)
    {
        if (is_callable($handler)) {
            call_user_func($handler, $params);
            return;
        }
        if (is_string($handler)) {
            // Format: Controller@method
            if (strpos($handler, '@') !== false) {
                list($controller, $method) = explode('@', $handler, 2);
                $class = '\\App\\Controllers\\' . $controller;
                if (class_exists($class)) {
                    $instance = new $class();
                    if (method_exists($instance, $method)) {
                        // Spread numeric order of params if any
                        call_user_func_array([$instance, $method], array_values($params));
                        return;
                    }
                }
            }
        }
        http_response_code(500);
        echo 'Route handler not callable.';
    }
}


