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
$routes->post('/course/enroll', 'Course::enroll');
$routes->match(['get','post'], 'course/enroll', 'Course::enroll');


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

// ✅ Student routes
$routes->group('student', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('dashboard', 'StudentDashboard::index');
    $routes->get('courses', 'StudentDashboard::courses');
    $routes->post('enroll/(:num)', 'StudentDashboard::enroll/$1');
});

// Role-based dashboards
$routes->group('admin', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('manage-users', 'Admin::manageUsers');
    $routes->get('manage-courses', 'Admin::manageCourses');
    $routes->get('activity-logs', 'Admin::activityLogs');
});

$routes->group('teacher', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('dashboard', 'Teacher::dashboard');
});

// Optional: test route for quick debugging
$routes->get('student/test-route', function() {
    return 'Student route OK';
});