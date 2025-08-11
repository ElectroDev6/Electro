<?php

use Core\Router;

// Home
Router::get('/', 'HomeController@index');

// Products
Router::get('/products', 'ProductController@showAll');

// Search
Router::get('/search/products', 'SearchProductController@searchProducts');
Router::get('/search/laptops', 'SearchLaptopController@searchLaptops');

// 🛒 Giỏ hàng
Router::get('/cart', 'CartController@showCart');
Router::post('/detail/add-to-cart', 'CartController@addToCart');
Router::post('/cart/select-all', 'CartController@selectAll');
Router::post('/cart/select-product', 'CartController@selectProduct');
Router::post('/cart/update-color', 'CartController@updateColor');
Router::post('/cart/update-quantity', 'CartController@updateQuantity');
Router::post('/cart/update-warranty', 'CartController@updateWarranty');
Router::post('/cart/delete', 'CartController@delete');
Router::post('/cart/apply-voucher', 'CartController@applyVoucher');
Router::post('/cart/confirm', 'CartController@confirm');

Router::get('/cart/item-count', 'CartController@getCartItemCount');

// 💳 Checkout
Router::get('/checkout', 'CheckoutController@index');        // Hiển thị trang checkout
Router::post('/checkout/submit', 'CheckoutController@submit'); // Xác nhận đặt hàng
Router::get('/checkout/vnpay', 'CheckoutController@vnpayCheckout'); // Thanh toán VNPay

// Router::get('/checkout', 'CheckoutController@showCheckoutForm');
Router::get('/thank-you', 'ThankyouController@showConfirmation');

// Auth
Router::get('/login', 'AuthController@showAuthForm');
Router::post('/handle-auth', 'AuthController@handleAuth');

// Product Detail
Router::get('/detail/:slug', 'DetailController@showDetail');
Router::post('/detail/add-to-cart', 'DetailController@addToCart');

// Information & Pages
Router::get('/about', 'AboutController@showAbout');
Router::get('/contact', 'ContactController@showContact');
Router::get('/profile', 'InforController@showProfile');
Router::get('/logout', 'InforController@logout');
Router::get('/history', 'HistoryController@showHistory');
Router::get('/policy-mobile', 'PolicyController@showMobilePolicy');
Router::get('/refund-policy', 'RefundController@showRefundPolicy');

// Other Features
Router::get('/clients', 'ClientController@showClients');
Router::get('/unboxing', 'UnboxingController@showUnboxing');
Router::get('/repair', 'RepairController@showRepair');

Router::get('/checkout', 'CheckoutController@index');

Router::get('/thankyou', 'ThankyouController@index');
Router::get('/thankyou', 'CheckoutController@thankyou');
Router::get('/delivery', 'DeliveryController@delivery');
Router::get('/customer', 'CustomerController@customer');
Router::get('/frequently_questions', 'frequently_questionsController@frequently_questions');
Router::get('/Introducing_shop', 'Introducing_shopController@introducing_shop');
