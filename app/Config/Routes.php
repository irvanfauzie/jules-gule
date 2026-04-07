<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/bank-data', 'Home::bankData');

$routes->get('/upload', 'Upload::index');
$routes->post('/upload/process', 'Upload::process');
$routes->get('/upload/delete/(:num)', 'Upload::delete/$1');

$routes->get('/chat', 'Chat::index');
$routes->post('/chat/send', 'Chat::send');
