<?php

use Core\Router;

Router::get('/', 'HomeController@index');
Router::get('/test', 'TestController@index');
Router::get('/product', 'ProductController@product');
Router::get('/productlaptop', 'ProductLaptopController@productLaptop');
Router::get('/searchproduct', 'SearchProductController@SearchProduct');
Router::get('/searchpdlaptop', 'SearchpdlaptopController@searchPdlaptop');
Router::get('/cart', 'CartController@index');
Router::get('/checkout', 'CheckoutController@index');
Router::get('/thankyou', 'ThankyouController@index');
Router::get('/about', 'AboutController@about');
Router::get('/contact', 'ContactController@contact');
Router::get('/login', 'LoginController@login');
Router::get('/register', 'AuthController@register');
Router::get('/detail/(\d+)', 'DetailController@detail');
Router::get('/infor', 'InforController@infor');
Router::get('/history', 'HistoryController@history');
Router::get('/policy', 'PolicyController@Policy');
Router::get('/information', 'InformationController@information');
Router::get('/refund', 'RefundController@refund');
Router::get('/client', 'ClientController@client');
Router::get('/unboxing', 'UnboxingController@Unboxing');
Router::get('/repair', 'RepairController@repair');
