<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public authentication routes
$routes->get('/', 'AuthController::index');
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// Routes that require a logged-in user
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Products
    $routes->get('products', 'ProductController::index');
    $routes->get('products/create', 'ProductController::create');
    $routes->post('products/store', 'ProductController::store');
    $routes->get('products/edit/(:num)', 'ProductController::edit/$1');
    $routes->post('products/update/(:num)', 'ProductController::update/$1');
    $routes->post('products/delete/(:num)', 'ProductController::delete/$1');

    // Customers
    $routes->get('customers', 'CustomerController::index');
    $routes->get('customers/create', 'CustomerController::create');
    $routes->post('customers/store', 'CustomerController::store');
    $routes->get('customers/edit/(:num)', 'CustomerController::edit/$1');
    $routes->post('customers/update/(:num)', 'CustomerController::update/$1');
    $routes->post('customers/delete/(:num)', 'CustomerController::delete/$1');

    // Staff users
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->post('users/delete/(:num)', 'UserController::delete/$1');

    // Sales
    $routes->get('sales', 'SaleController::index');
    $routes->get('sales/create', 'SaleController::create');
    $routes->post('sales/store', 'SaleController::store');
});