<?php

namespace Core;

class Router
{
    protected static array $routes = [];

    public static function get(string $uri, string $controllerAction)
    {
        self::$routes['GET'][$uri] = $controllerAction;
    }

    public static function post(string $uri, string $controllerAction)
    {
        self::$routes['POST'][$uri] = $controllerAction;
    }

    public static function dispatch(string $uri, string $method)
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $method = strtoupper($method);

        if (!isset(self::$routes[$method][$path])) {
            http_response_code(404);
            echo "404 - Not Found";
            exit;
        }

        [$controller, $action] = explode('@', self::$routes[$method][$path]);

        // Tự xác định không gian tên theo URI
        $namespace = str_starts_with($path, '/admin')
            ? 'App\Controllers\Admin\\'
            : 'App\Controllers\Web\\';

        $controllerClass = $namespace . $controller;

        if (!class_exists($controllerClass)) {
            echo "Controller $controllerClass not found";
            exit;
        }

        // Lấy kết nói PDO từ Container
        $pdo = \Container::get('pdo');

        if ($pdo === null) {
            echo "Database connection not initialized";
            exit;
        }

        $instance = new $controllerClass($pdo);

        if (!method_exists($instance, $action)) {
            echo "Method $action not found in $controllerClass";
            exit;
        }

        // Gọi action
        call_user_func([$instance, $action]);
    }
}
