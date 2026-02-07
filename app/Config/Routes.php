<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// =======================
// CUSTOMER (PUBLIC)
// =======================
$routes->get('/', 'ShopController::index');
$routes->get('menu/(:num)', 'ShopController::detail/$1');

$routes->get('cart', 'CartController::index');
$routes->post('cart/add', 'CartController::add');
$routes->post('cart/update', 'CartController::update');
$routes->post('cart/remove', 'CartController::remove');

// Customer Auth
$routes->get('register', 'CustomerAuthController::registerForm');
$routes->post('register', 'CustomerAuthController::register');
$routes->get('login', 'CustomerAuthController::loginForm');
$routes->post('login', 'CustomerAuthController::login');
$routes->get('logout', 'CustomerAuthController::logout');

// app/Config/Routes.php
$routes->get('promo', 'ShopController::promo');
$routes->get('kontak', 'ShopController::kontak');

// Customer protected
$routes->group('', ['filter' => 'customerauth'], function ($routes) {
    $routes->get('checkout', 'CheckoutController::index', ['filter' => 'customerauth']);
    $routes->post('checkout', 'CheckoutController::placeOrder', ['filter' => 'customerauth']);

    // ✅ RIWAYAT PESANAN
    $routes->get('orders', 'OrderController::index');

    $routes->get('order/(:segment)', 'OrderController::show/$1');
    $routes->get('order/(:segment)/wa', 'OrderController::whatsapp/$1');


});


// =======================
// ADMIN
// =======================
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // Admin Auth
    $routes->get('login', 'AuthController::loginForm');
    $routes->post('login', 'AuthController::login');

    // ✅ TAMBAHKAN INI (Admin Register)
    $routes->get('register', 'AuthController::registerForm');
    $routes->post('register', 'AuthController::register');

    $routes->get('logout', 'AuthController::logout');

    // Protected admin routes
    $routes->group('', ['filter' => 'adminauth'], function ($routes) {
        $routes->get('dashboard', 'DashboardController::index');

        $routes->get('menus', 'MenuController::index');
        $routes->get('menus/create', 'MenuController::create');
        $routes->post('menus', 'MenuController::store');
        $routes->get('menus/(:num)/edit', 'MenuController::edit/$1');
        $routes->post('menus/(:num)', 'MenuController::update/$1');
        $routes->post('menus/(:num)/delete', 'MenuController::delete/$1');
        $routes->get('banners', 'BannerController::index');
        $routes->get('promo', 'PromoController::index');
        $routes->get('promo/create', 'PromoController::create');
        $routes->post('promo', 'PromoController::store');
        $routes->get('promo/(:num)/edit', 'PromoController::edit/$1');
        $routes->post('promo/(:num)', 'PromoController::update/$1');
        $routes->post('promo/(:num)/delete', 'PromoController::delete/$1');
        $routes->post('promo/generate', 'PromoController::generate');


        $routes->get('orders', 'OrderController::index');
        $routes->get('orders/(:num)', 'OrderController::show/$1');
        $routes->post('orders/(:num)/status', 'OrderController::updateStatus/$1');


        $routes->get('queue', 'QueueController::index');
        $routes->post('queue/(:num)/status', 'QueueController::updateStatus/$1');

        $routes->get('wa-templates', 'WaTemplateController::index');
        $routes->post('wa-templates', 'WaTemplateController::save');


        $routes->get('reports/finance', 'ReportController::finance');
        $routes->get('settings/kontak', 'SettingsController::kontak');
        $routes->post('settings/kontak', 'SettingsController::kontakSave');


        $routes->get('banners', 'BannerController::index');
        $routes->get('banners/create', 'BannerController::create');
        $routes->post('banners', 'BannerController::store');
        $routes->get('banners/(:num)/edit', 'BannerController::edit/$1');
        $routes->post('banners/(:num)', 'BannerController::update/$1');
        $routes->post('banners/(:num)/delete', 'BannerController::delete/$1');

    });
});
