<?php

use Core\Router;

Router::get('/', 'HomeController@index');
Router::get('/product', 'ProductController@product');
Router::get('/about', 'AboutController@about');
Router::get('/contact', 'ContactController@contact');
Router::get('/login', 'AuthController@login');
Router::get('/register', 'AuthController@register');
