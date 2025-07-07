<?php

require_once BASE_PATH . './config/db.php';

// Container để quản lý phụ thuộc
class Container
{
    private static $instances = [];

    public static function set($key, $value)
    {
        self::$instances[$key] = $value;
    }

    public static function get($key)
    {
        return self::$instances[$key] ?? null;
    }
}

Container::set('pdo', $pdo);
