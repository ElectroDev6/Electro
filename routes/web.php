<?php

use App\Controllers\Web\ClientController;
use App\Controllers\Web\deliveryController;
use App\Controllers\Web\informationController;
use App\Controllers\Web\refundController;
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
Router::get('/refund', 'refundController@refund');
Router::get('/client', 'ClientController@client');
Router::get('/Unboxing', 'UnboxingController@Unboxing');
Router::get('/repair', 'RepairController@Repair');
