<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');
$routes->get('/test', 'Home::test');
$routes->get('student-dashboard', 'StudentDashboard::index');
$routes->post('admin/enroll', 'CourseController::enroll');


$routes->post('/course/enroll', 'Course::enroll');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');

$routes->get('/login-simple', 'AuthSimple::login');
$routes->post('/login-simple', 'AuthSimple::login');

$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard-show', 'Dashboard::index');

$routes->get('/dashboard-simple', 'Auth::dashboardSimple');

$routes->group('student', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('dashboard', 'StudentDashboard::index');
    $routes->get('courses', 'StudentDashboard::courses');
    $routes->post('enroll/(:num)', 'StudentDashboard::enroll/$1'); // Traditional form post
});

// --- NEW API ROUTES ---
// Apply your authentication filter (e.g., 'session', 'auth_api', etc.)
$routes->group('api', ['namespace' => 'App\Controllers', 'filter' => 'session'], function ($routes) { // Using 'session' filter as common CI4 practice
    $routes->post('student/enroll/(:num)', 'StudentDashboard::apiEnroll/$1');
    $routes->get('student/enrolled-courses', 'StudentDashboard::getEnrolledCourses');
    $routes->get('courses/available', 'StudentDashboard::getAvailableCourses');
});

$routes->group('admin', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('manage-users', 'Admin::manageUsers');
    $routes->get('manage-courses', 'Admin::manageCourses');
    $routes->get('activity-logs', 'Admin::activityLogs');
});

$routes->group('teacher', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('dashboard', 'Teacher::dashboard');
});

$routes->get('student/test-route', function() {
    return 'Student route OK';
});