<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Custom routes for Home controller
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');
$routes->get('/test', 'Home::test');

// Additional routes for flexibility
$routes->get('home', 'Home::index');