<?php

require_once __DIR__ . '/env.php';

loadEnv(__DIR__ . '/.env');

return [
    'db' => [
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'name' => $_ENV['DB_DATABASE'],
        'user' => $_ENV['DB_USERNAME'],
        'pass' => $_ENV['DB_PASSWORD'],
    ]
];
