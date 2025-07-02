<?php

$config = require __DIR__ . '/config.php';

try {
    $pdo = new PDO(
        'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'] . ';port=' . $config['db']['port'],
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('DB connection failed: ' . $e->getMessage());
}
