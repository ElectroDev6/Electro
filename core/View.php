<?php

namespace Core;

class View
{
    protected static $sections = [];
    protected static $currentSection = null;
    protected static $layout = null;

    public static function render($viewPath, $data = [])
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

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

        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        $peakMemory = memory_get_peak_usage();

        // Format
        $renderTime = number_format(($endTime - $startTime) * 1000, 2); // ms
        $usedMemory = number_format(($endMemory - $startMemory) / 1024, 2); // KB
        $peakMemoryFormatted = number_format($peakMemory / 1024, 2); // KB

        // Log to file (logs/view.log)
        $logMessage = sprintf(
            "[%s] Rendered view: %s | Time: %sms | Used: %sKB | Peak: %sKB\n",
            date('Y-m-d H:i:s'),
            $viewPath,
            $renderTime,
            $usedMemory,
            $peakMemoryFormatted
        );

        error_log($logMessage, 3, BASE_PATH . '/storage/logs/view.log');
    }


    protected static function viewFile($view)
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (str_starts_with(trim($uri, '/'), 'admin')) {
            $viewPath = BASE_PATH . '/app/views/admin/' . str_replace('.', '/', $view) . '.php';
            $layoutPath = BASE_PATH . '/app/views/admin/layouts/main.php';
        } else {
            $viewPath = BASE_PATH . '/app/views/web/' . str_replace('.', '/', $view) . '.php';
            $layoutPath = BASE_PATH . '/app/views/web/layouts/main.php';
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

    public static function component($viewPath)
    {
        require self::viewFile($viewPath);
    }

    public static function e($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
