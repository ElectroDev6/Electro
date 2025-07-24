<?php

use App\Controllers\Web\informationController;
use Core\Router;

Router::get('/', 'HomeController@index');
Router::get('/product', 'ProductController@product');
Router::get('/about', 'AboutController@about');
Router::get('/contact', 'ContactController@contact');
Router::get('/login', 'AuthController@login');
Router::get('/register', 'AuthController@register');
Router::get('/detail/(\d+)', 'DetailController@detail');
Router::get('/cart', 'CartController@index');
Router::get('/Policy', 'PolicyController@Policy');
Router::get('/information', 'informationController@information');
