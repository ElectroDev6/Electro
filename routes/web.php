<?php

use Core\Router;

Router::get('/', 'HomeController@index');
Router::get('/product', 'ProductController@product');
