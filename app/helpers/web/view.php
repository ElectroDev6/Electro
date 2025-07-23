<?php

function render($page, $data = [])
{
    extract($data);

    // Lấy URI hiện tại
    $uri = $_SERVER['REQUEST_URI'];

    // Xác định layout và đường dẫn view theo context
    if (str_starts_with(trim($uri, '/'), 'admin')) {
        $view = BASE_PATH . "/app/views/admin/$page.php";
        $layout = BASE_PATH . '/app/views/admin/layout/main.php';
    } else {
        $view = BASE_PATH . "/app/views/web/$page.php";
        $layout = BASE_PATH . '/app/views/web/layout/main.php';
    }

    $pageName = basename($page); // (vd: 'products', 'about', 'dashboard')
    require $layout;
}