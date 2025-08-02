<?php

use App\Controllers\Web\ClientController;
use App\Controllers\Web\deliveryController;
use App\Controllers\Web\informationController;
use App\Controllers\Web\refundController;
use Core\Router;

Router::get('/', 'HomeController@index');
Router::get('/test', 'TestController@index');
Router::get('/product', 'ProductController@product');
Router::get('/cart', 'CartController@index'); // Thêm route cho giỏ hàng
Router::get('/about', 'AboutController@about');
Router::get('/contact', 'ContactController@contact');
Router::get('/login', 'LoginController@login');
Router::get('/register', 'AuthController@register');
Router::get('/detail/(\d+)', 'DetailController@detail');
Router::get('/cart', 'CartController@index');
Router::get('/policy', 'PolicyController@Policy');
Router::get('/information', 'InformationController@information');
Router::get('/refund', 'RefundController@refund');
Router::get('/client', 'ClientController@client');
Router::get('/unboxing', 'UnboxingController@Unboxing');
Router::get('/repair', 'RepairController@repair');
Router::get('/delivery', 'DeliveryController@delivery');
Router::get('/customer', 'CustomerController@customer');
Router::get('/frequently_questions', 'frequently_questionsController@frequently_questions');
Router::get('/Introducing_shop', 'Introducing_shopController@introducing_shop');
