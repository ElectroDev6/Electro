<?php

use Core\Router;

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', 'http://electro.test');

require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/core/Container.php';
require_once BASE_PATH . '/core/View.php';
require_once BASE_PATH . '/app/helpers/asset.php';
require_once BASE_PATH . '/routes/web.php';
require_once BASE_PATH . '/routes/admin.php';

Router::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
