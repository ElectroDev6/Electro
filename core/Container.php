<?php

class Container
{
    private static $bindings = [];
    private static $instances = [];

    // Đăng ký service với closure (hàm)
    public static function bind($key, Closure $resolver)
    {
        self::$bindings[$key] = $resolver;
    }

    // Lấy đối tượng
    public static function get($key)
    {
        if (isset(self::$instances[$key])) {
            return self::$instances[$key];
        }

        if (isset(self::$bindings[$key])) {
            // Gọi closure để tạo object rồi lưu lại
            self::$instances[$key] = call_user_func(self::$bindings[$key]);
            return self::$instances[$key];
        }

        return null;
    }
}

// Đăng ký cách tạo PDO (chưa tạo ngay)
Container::bind('pdo', function () {
    $config = require BASE_PATH . '/config/db.php';
    return createPDO();
});
