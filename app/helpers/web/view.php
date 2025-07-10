<?php

function render($page, $data = [])
{
    extract($data);
    $view = BASE_PATH . "/app/views/web/$page.php";
    require BASE_PATH . '/app/views/web/layout/main.php';
}
