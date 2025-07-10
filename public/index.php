<?php

use Core\Router;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/app/helpers/web/view.php';
require_once BASE_PATH . '/routes/web.php';
require_once BASE_PATH . '/routes/admin.php';

Router::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
