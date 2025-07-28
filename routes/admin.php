<?php

use Core\Router;

Router::get('/admin', 'DashboardController@index');
Router::get('/admin/products', 'ProductsController@index');
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
// ReviewsController tên file và function index() không thay đổi còn ReviewsController chỉ là tên class
