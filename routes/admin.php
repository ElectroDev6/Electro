<?php

use Core\Router;

// Các route GET hiện tại
Router::get('/admin/index', 'DashboardController@index');

// Routes for Categories (unchanged, for reference)
Router::get('/admin/categories', 'CategoriesController@index'); 
Router::get('/admin/categories/create', 'CategoriesController@create'); 
Router::post('/admin/categories/handleCreate', 'CategoriesController@handleCreate');
Router::get('/admin/categories/detail', 'CategoriesController@detail');
Router::get('/admin/categories/update', 'CategoriesController@update'); 
Router::post('/admin/categories/update', 'CategoriesController@handleUpdate'); 
Router::get('/admin/categories/delete', 'CategoriesController@delete');



Router::get('/admin/products', 'ProductsController@index'); 
Router::get('/admin/products/create', 'ProductsController@create'); 
Router::post('/admin/products/handleCreate', 'ProductsController@handleCreate');
Router::get('/admin/products/detail', 'ProductsController@detail');
Router::get('/admin/products/update', 'ProductsController@update');
Router::post('/admin/products/update/handle', 'ProductsController@handle');
Router::get('/admin/products/delete', 'ProductsController@delete');


Router::get('/admin/comments', 'CommentsController@index');
Router::get('/admin/commentDetail', 'CommentDetailController@index');
Router::post('/admin/comments/approve', 'CommentDetailController@approve');
Router::post('/admin/comments/reject', 'CommentDetailController@reject');
Router::post('/admin/comments/delete', 'CommentDetailController@delete');
Router::get('/admin/comments/edit', 'CommentDetailController@edit');
Router::post('/admin/comments/editComment', 'CommentDetailController@edit');
Router::post('/admin/commentDetail/reply', 'CommentDetailController@reply');



Router::get('/admin/users', 'UsersController@index');
Router::get('/admin/userDetail', 'UserDetailController@index');
Router::get('/admin/orders', 'OrdersController@index');
Router::get('/admin/orderDetail', 'OrderDetailController@index');
Router::get('/admin/reviews', 'ReviewsController@index');
Router::get('/admin/reviewDetail', 'ReviewDetailController@index');
Router::get('/admin/blogs', 'BlogsController@index');
Router::get('/admin/profile', 'ProfileController@index');
