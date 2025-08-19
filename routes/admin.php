<?php

use Core\Router;

// Các route GET hiện tại
Router::get('/admin/index', 'DashboardController@index');

// Routes for Categories (unchanged, for reference)
Router::get('/admin/categories', 'CategoriesController@index'); 
Router::get('/admin/categories/create', 'CategoriesController@create'); 
Router::post('/admin/categories/handleCreate', 'CategoriesController@handleCreate');
Router::post('/admin/categories/delete', 'CategoriesController@delete');
Router::get('/admin/categories/detail', 'CategoriesController@detail');
Router::get('/admin/categories/update', 'CategoriesController@update'); 
Router::post('/admin/categories/update', 'CategoriesController@handleUpdate'); 


// Thêm route mới cho subcategories
Router::get('/admin/categories/subcategories', 'CategoriesController@getSubcategories');



Router::get('/admin/users', 'UsersController@index');
Router::post('/admin/users/toggle-lock', 'UsersController@toggleUserLock');
Router::get('/admin/users/create', 'UsersController@create');
Router::post('/admin/users/handleCreate', 'UsersController@handleCreate');
Router::post('/admin/users/delete', 'UsersController@delete');
Router::get('/admin/users/detail', 'UsersController@detail');
Router::get('/admin/users/update', 'UsersController@update');
Router::post('/admin/users/update', 'UsersController@handleUpdate');

Router::get('/admin/users/getCurrentUser', 'UsersController@user');


Router::get('/admin/notifications', 'NotificationController@index');







Router::get('/admin/products', 'ProductsController@index'); 
Router::get('/admin/products/detail', 'ProductsController@detail');
Router::get('/admin/products/create', 'ProductsController@create'); 
Router::post('/admin/products/handleCreate', 'ProductsController@handleCreate');
Router::get('/admin/products/update', 'ProductsController@update');
Router::post('/admin/products/update/handle', 'ProductsController@handle');
Router::get('/admin/products/delete', 'ProductsController@delete');


Router::get('/admin/reviews', 'ReviewsController@index'); 
Router::get('/admin/reviews/create', 'ReviewsController@create'); 
Router::post('/admin/reviews/handleCreate', 'ReviewsController@handleCreate');
Router::get('/admin/reviews/detail', 'ReviewsController@detail');
Router::post('/admin/reviews/update-status', 'ReviewsController@updateStatus');
Router::post('/admin/reviews/update/handle', 'ReviewsController@handle');
Router::post('/admin/reviews/delete', 'ReviewsController@delete');
Router::post('/admin/reviews/reply', 'ReviewsController@handleRepl');


Router::get('/admin/orders', 'OrdersController@index');
Router::get('/admin/orders/detail', 'OrdersController@detail');
Router::post('/admin/orders/status', 'OrdersController@status');


Router::get('/admin/comments', 'CommentsController@index');
Router::get('/admin/commentDetail', 'CommentDetailController@index');
Router::post('/admin/comments/approve', 'CommentDetailController@approve');
Router::post('/admin/comments/reject', 'CommentDetailController@reject');
Router::post('/admin/comments/delete', 'CommentDetailController@delete');
Router::get('/admin/comments/edit', 'CommentDetailController@edit');
Router::post('/admin/comments/editComment', 'CommentDetailController@edit');
Router::post('/admin/commentDetail/reply', 'CommentDetailController@reply');




Router::get('/admin/blogs', 'BlogsController@index');
Router::get('/admin/profile', 'ProfileController@index');
