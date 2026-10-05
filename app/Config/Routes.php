<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->post('/logout', 'AuthController::logout');

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/
$routes->get('/products', 'ProductController::index', ['filter' => 'auth']);
$routes->get('/products/new', 'ProductController::createForm', ['filter' => 'auth']);
$routes->post('/products', 'ProductController::create', ['filter' => 'auth']);
$routes->get('/products/(:num)/edit', 'ProductController::edit/$1', ['filter' => 'auth']);
$routes->post('/products/(:num)', 'ProductController::update/$1', ['filter' => 'auth']);
$routes->post('/products/(:num)/delete', 'ProductController::delete/$1', ['filter' => 'auth']);

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
$routes->get('/customers', 'CustomerController::index', ['filter' => 'auth']);
$routes->get('/customers/new', 'CustomerController::createForm', ['filter' => 'auth']);
$routes->post('/customers', 'CustomerController::create', ['filter' => 'auth']);
$routes->get('/customers/(:num)/edit', 'CustomerController::edit/$1', ['filter' => 'auth']);
$routes->post('/customers/(:num)', 'CustomerController::update/$1', ['filter' => 'auth']);
$routes->post('/customers/(:num)/delete', 'CustomerController::delete/$1', ['filter' => 'auth']);

/*
|--------------------------------------------------------------------------
| Staff/User Routes
|--------------------------------------------------------------------------
*/
$routes->get('/users', 'UserController::index', ['filter' => 'auth']);
$routes->get('/users/new', 'UserController::createForm', ['filter' => 'auth']);
$routes->post('/users', 'UserController::create', ['filter' => 'auth']);
$routes->get('/users/(:num)/edit', 'UserController::edit/$1', ['filter' => 'auth']);
$routes->post('/users/(:num)', 'UserController::update/$1', ['filter' => 'auth']);
$routes->post('/users/(:num)/delete', 'UserController::delete/$1', ['filter' => 'auth']);

/*
|--------------------------------------------------------------------------
| Sales Routes
|--------------------------------------------------------------------------
*/
$routes->get('/sales', 'SaleController::index', ['filter' => 'auth']);
$routes->get('/sales/new', 'SaleController::createForm', ['filter' => 'auth']);
$routes->post('/sales', 'SaleController::create', ['filter' => 'auth']);