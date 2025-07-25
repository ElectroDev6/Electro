<?php

namespace Core;

class View
{
    protected static $sections = [];
    protected static $currentSection = null;
    protected static $layout = null;

    public static function render($viewPath, $data = [])
    {
        extract($data);

        $pageName = basename($viewPath);

        ob_start();
        require self::viewFile($viewPath);
        $content = ob_get_clean();

        if (self::$layout) {
            require self::viewFile(self::$layout);
        } else {
            echo $content;
        }
    }

    protected static function viewFile($view)
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (str_starts_with(trim($uri, '/'), 'admin')) {
            $viewPath = BASE_PATH . '/app/views/admin/' . str_replace('.', '/', $view) . '.php';
            $layoutPath = BASE_PATH . '/app/views/admin/layouts/main.php';
        } else {
            $viewPath = BASE_PATH . '/app/views/web/' . str_replace('.', '/', $view) . '.php';
        }

        return $viewPath;
    }

    public static function extend($layout)
    {
        self::$layout = $layout;
    }

    public static function section($name)
    {
        if (self::$currentSection) {
            throw new \Exception("Cannot nest sections.");
        }
        self::$currentSection = $name;
        ob_start();
    }

    public static function endSection()
    {
        if (!self::$currentSection) {
            throw new \Exception("No section started.");
        }
        self::$sections[self::$currentSection] = ob_get_clean();
        self::$currentSection = null;
    }

    public static function yield($name, $default = '')
    {
        echo self::$sections[$name] ?? $default;
    }

    public static function partial($viewPath, $data = [])
    {
        extract($data);
        require self::viewFile($viewPath);
    }

    public static function e($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
