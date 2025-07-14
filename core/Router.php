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

        foreach (self::$routes[$method] as $route => $handler) {
            // Chuyển $route thành biểu thức chính quy
            $pattern = '#^' . $route . '$#';

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Bỏ phần match đầy đủ

                [$controller, $action] = explode('@', $handler);

                $namespace = str_starts_with($path, '/admin')
                    ? 'App\Controllers\Admin\\'
                    : 'App\Controllers\Web\\';

                $controllerClass = $namespace . $controller;

                if (!class_exists($controllerClass)) {
                    echo "Controller $controllerClass not found";
                    exit;
                }

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

                // Truyền thêm tham số động vào controller method
                call_user_func_array([$instance, $action], $matches);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Not Found";
    }
}
