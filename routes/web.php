<?php

use Core\Router;

// Home
Router::get('/', 'HomeController@index');

// Products
Router::get('/products/iphone', 'ProductController@showAll');
Router::get('/products/laptops', 'ProductLaptopController@showAllLaptops');

// Search
Router::get('/search/products', 'SearchProductController@searchProducts');
Router::get('/search/laptops', 'SearchLaptopController@searchLaptops');

// Cart & Order
Router::get('/cart', 'CartController@showCart');
// Router::get('/checkout', 'CheckoutController@showCheckoutForm');
Router::get('/thank-you', 'ThankyouController@showConfirmation');

// Auth
Router::get('/login', 'LoginController@showLoginForm');
// Router::get('/register', 'AuthController@showRegisterForm');

// Product Detail
Router::get('/product/:slug', 'DetailController@showDetail');
Router::post('/detail/add-to-cart', 'DetailController@addToCart');

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


Router::post('/cart/add', 'CartController@add');
Router::post('/cart/update-quantity', 'CartController@updateQuantity');
Router::post('/cart/delete', 'CartController@delete');
Router::post('/cart/select-all', 'CartController@selectAll');
Router::post('/cart/unselect-all', 'CartController@unselectAll');
Router::post('/cart/toggle-select', 'CartController@toggleSelect');
Router::post('/cart/toggle-warranty', 'CartController@toggleWarranty');
Router::post('/cart/update-color', 'CartController@updateColor');
Router::get('/checkout', 'CheckoutController@index');
Router::post('/checkout', 'CheckoutController@submit');
Router::post('/checkout/vnpay', 'CheckoutController@vnpayCheckout');
Router::post('/checkout/submit', 'CheckoutController@submit');
Router::get('/thankyou', 'ThankyouController@index');
Router::get('/thankyou', 'CheckoutController@thankyou');
