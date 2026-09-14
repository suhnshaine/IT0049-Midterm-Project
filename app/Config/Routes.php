<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('/products', 'ProductController::index');
$routes->get('/customers', 'CustomerController::index');
$routes->get('/users', 'UserController::index');