<?php

function createPDO()
{
    $config = require __DIR__ . '/config.php';

    return new PDO(
        'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'] . ';port=' . $config['db']['port'],
        $config['db']['user'],
        $config['db']['pass']
    );
}
