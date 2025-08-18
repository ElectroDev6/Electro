<?php

namespace App\Middlewares;

class AdminMiddleware
{
    public static function handle()
    {
        // Kiểm tra nếu chưa login hoặc không phải admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /forbidden');
            exit;
        }
    }
}
