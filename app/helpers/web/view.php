<?php

function render($page, $data = [])
{
    extract($data);
    $view = BASE_PATH . "/app/views/web/$page.php";
    $pageName = basename($page); // Lấy tên file view (vd: 'about', 'contact')

    require BASE_PATH . '/app/views/web/layout/main.php';
}