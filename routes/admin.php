<?php

use Core\Router;

// Các route GET hiện tại
Router::get('/admin/index', 'DashboardController@index');


Router::get('/admin/products/index', 'products\ProductsController@index');
Router::get('/admin/products/detail', 'products\ProductDetailController@index');
Router::get('/admin/products/create', 'products\CreateProductController@index');


Router::get('/admin/categories', 'CategoriesController@index'); // Danh sách
Router::get('/admin/categories/create', 'CategoriesController@create'); // Form tạo
Router::post('/admin/categories/handleCreate', 'CategoriesController@handleCreate');
Router::get('/admin/categories/detail', 'CategoriesController@detail');
Router::get('/admin/categories/update', 'CategoriesController@update');
Router::post('/admin/categories/update', 'CategoriesController@handleUpdate');
Router::get('/admin/categories/delete', 'CategoriesController@delete');

Router::get('/admin/users', 'UsersController@index');
Router::get('/admin/userDetail', 'UserDetailController@index');
Router::get('/admin/orders', 'OrdersController@index');
Router::get('/admin/orderDetail', 'OrderDetailController@index');
Router::get('/admin/comments', 'CommentsController@index');
Router::get('/admin/commentDetail', 'CommentDetailController@index');
Router::get('/admin/reviews', 'ReviewsController@index');
Router::get('/admin/reviewDetail', 'ReviewDetailController@index');
Router::get('/admin/blogs', 'BlogsController@index');
Router::get('/admin/profile', 'ProfileController@index');
