<?php

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
Router::get('/productlaptop', 'ProductLaptopController@productLaptop'); // Thêm
Router::get('/searchproduct', 'SearchProductController@SearchProduct'); // Thêm
Router::get('/searchpdlaptop', 'SearchpdlaptopController@searchPdlaptop'); // Thêm route tìm kiếm sản phẩm laptop
Router::get('/infor', 'InforController@infor'); // Thêm route cho trang thông tin
Router::get('/history', 'HistoryController@history'); // Thêm route cho lich su don hang
Router::get('/detail', 'DetailController@detail'); // Thêm route cho trang thanh toán
