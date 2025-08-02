<?php

use Core\Router;

Router::get('/', 'HomeController@index');
Router::get('/test', 'TestController@index');
Router::get('/product', 'ProductController@product');
Router::get('/cart', 'CartController@index'); 
Router::get('/about', 'AboutController@about');
Router::get('/contact', 'ContactController@contact');
Router::get('/login', 'LoginController@login');
Router::post('/handle-auth', 'LoginController@handleAuth');
Router::get('/register', 'AuthController@register');
Router::get('/detail/(\d+)', 'DetailController@detail');
Router::get('/infor', 'InforController@infor');//
Router::get('/history', 'HistoryController@history');//
Router::get('/admin/dashboard', 'AdminController@dashboard'); // Thêm route cho lich su don hang