<?php

function asset(string $path): string
{
    $isLocal = strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || $_SERVER['HTTP_HOST'] === 'electro.test';
    return BASE_URL . ($isLocal ? '' : '/public/') . ltrim($path, '/');
}
