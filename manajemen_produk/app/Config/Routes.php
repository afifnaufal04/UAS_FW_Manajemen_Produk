<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'ProdukController::index');
$routes->get('/produk/create', 'ProdukController::create');
$routes->post('/produk/store', 'ProdukController::store');
$routes->get('/produk/edit/(:num)', 'ProdukController::edit/$1');
$routes->post('/produk/update/(:num)', 'ProdukController::update/$1');
$routes->post('/produk/delete/(:num)', 'ProdukController::delete/$1');