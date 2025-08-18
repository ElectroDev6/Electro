<?php
session_start();

use Core\Router;

$isLocal = strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false || $_SERVER['HTTP_HOST'] === 'electro.test';
define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', $isLocal ? 'http://electro.test/' : 'https://electro.id.vn');

require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/core/Container.php';
require_once BASE_PATH . '/core/View.php';
require_once BASE_PATH . '/app/helpers/asset.php';
require_once BASE_PATH . '/routes/web.php';
require_once BASE_PATH . '/routes/admin.php';
require_once BASE_PATH . '/app/helpers/cart_helper.php';

$found = Router::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

if ($found === false) {
    require_once BASE_PATH . '/app/views/web/errors/404.php';
}
