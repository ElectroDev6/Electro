<?php

namespace App\Controllers\Web;

class HomeController
{
    public function index()
    {
        echo "Đây là trang chủ!";
        require_once BASE_PATH . '/app/views/home.php';
    }
}
