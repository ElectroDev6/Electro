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

  // File: core/Router.php
  public static function dispatch(string $uri, string $method)
  {
    $path = parse_url($uri, PHP_URL_PATH);
    $method = strtoupper($method);

    error_log("Router: Dispatching URI: $uri, Method: $method, Path: $path");

    foreach (self::$routes[$method] as $route => $handler) {
      // Thay tất cả tham số động (:param) bằng ([^/]+)
      $pattern = preg_replace('#:[\w]+#', '([^/]+)', $route);
      $pattern = '#^' . $pattern . '$#';
      // error_log("Router: Trying pattern: $pattern for route: $route");
      if (preg_match($pattern, $path, $matches)) {
        array_shift($matches);
        error_log("Router: Matched route: $route, Handler: $handler, Matches: " . json_encode($matches));

        [$controller, $action] = explode('@', $handler);
        $namespace = str_starts_with($path, '/admin')
          ? 'App\Controllers\Admin\\'
          : 'App\Controllers\Web\\';
        $controllerClass = $namespace . $controller;

        if (!class_exists($controllerClass)) {
          error_log("Router: Controller $controllerClass not found");
          echo "Controller $controllerClass not found";
          exit;
        }

        $pdo = \Container::get('pdo');
        if ($pdo === null) {
          error_log("Router: Database connection not initialized");
          echo "Database connection not initialized";
          exit;
        }

        $instance = new $controllerClass($pdo);
        if (!method_exists($instance, $action)) {
          error_log("Router: Method $action not found in $controllerClass");
          echo "Method $action not found in $controllerClass";
          exit;
        }

        $input = [];
        if ($method === 'POST' && isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
          $json = file_get_contents('php://input');
          $input = json_decode($json, true) ?: [];
          error_log("Router: Raw JSON: $json, Parsed Input: " . json_encode($input));
        }

        $params = ($method === 'GET') ? $matches : array_merge([$input], $matches);
        error_log("Router: Calling $controllerClass->$action with params: " . json_encode($params));
        call_user_func_array([$instance, $action], $params);
        return;
      }
    }

    error_log("Router: No route matched for $path");
    error_log("Router: Dispatching URI: $uri, Method: $method, Path: $path");
    error_log("Router: Registered routes: " . json_encode(self::$routes));
    return false;
  }
}
