<?php

use Core\Router;

// Home
Router::get('/', 'HomeController@index');

// Products
Router::get('/products', 'ProductController@showAll');
Router::get('/products/laptops', 'ProductLaptopController@showAllLaptops');

// Search
Router::get('/search/products', 'SearchProductController@searchProducts');
Router::get('/search/laptops', 'SearchLaptopController@searchLaptops');

// Cart & Order
Router::get('/cart', 'CartController@showCart');
Router::get('/checkout', 'CheckoutController@showCheckoutForm');
Router::get('/thank-you', 'ThankyouController@showConfirmation');

// Auth
Router::get('/login', 'LoginController@showLoginForm');
// Router::get('/register', 'AuthController@showRegisterForm');

// Product Detail
Router::get('/product/([\w\-]+)', 'DetailController@showDetail');

// Information & Pages
Router::get('/about', 'AboutController@showAbout');
Router::get('/contact', 'ContactController@showContact');
Router::get('/profile', 'ProfileController@showProfile');
Router::get('/history', 'HistoryController@showHistory');
Router::get('/policy-mobile', 'PolicyController@showMobilePolicy');
Router::get('/refund-policy', 'RefundController@showRefundPolicy');
Router::get('/privacy-policy', 'RefundController@showPrivacyPolicy');

// Other Features
Router::get('/clients', 'ClientController@showClients');
Router::get('/unboxing', 'UnboxingController@showUnboxing');
Router::get('/repair', 'RepairController@showRepair');
