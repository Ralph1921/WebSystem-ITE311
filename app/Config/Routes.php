<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default routes
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');
$routes->get('/test', 'Home::test');

// Authentication routes
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');

// WORKING LOGIN - NO DATABASE REQUIRED
$routes->get('/login-simple', 'AuthSimple::login');
$routes->post('/login-simple', 'AuthSimple::login');

// Main auth routes
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/logout', 'Auth::logout');

// Working dashboard (no login required for testing)
$routes->get('/dashboard-show', 'Dashboard::index');

// Simple dashboard test (with login required)
$routes->get('/dashboard-simple', 'Auth::dashboardSimple');

// Role-based dashboards
$routes->group('admin', function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
});
$routes->group('teacher', function ($routes) {
    $routes->get('dashboard', 'Teacher::dashboard');
});
$routes->group('student', function ($routes) {
    $routes->get('dashboard', 'Student::dashboard');
});
