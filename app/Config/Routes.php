<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');

// Announcement routes
$routes->get('/announcements', 'Announcement::index');

// Authentication routes
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');

$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Auth::dashboard');

// Course routes
$routes->get('/courses', 'Course::index');
$routes->get('/course/view/(:num)', 'Course::view/$1');
$routes->post('/course/enroll', 'Course::enroll');

// Material routes - STEP 8 IMPLEMENTATION
$routes->post('/material/upload', 'Material::upload');
$routes->get('/material/download/(:num)', 'Material::download/$1');
$routes->post('/material/delete/(:num)', 'Material::delete/$1');

// Admin Routes - NO FILTER for now to test
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('users', 'Admin::users');
    $routes->get('courses', 'Admin::courses');
    $routes->get('reports', 'Admin::reports');
    $routes->get('settings', 'Admin::settings');
});

// Teacher Routes - NO FILTER for now to test
$routes->group('teacher', function($routes) {
    $routes->get('dashboard', 'Teacher::dashboard');
    $routes->get('courses', 'Teacher::courses');
    $routes->get('gradebook', 'Teacher::gradebook');
    $routes->get('assignments', 'Teacher::assignments');
    $routes->get('students', 'Teacher::students');
});

// Student routes
$routes->get('/student/dashboard', 'Auth::dashboard');
$routes->get('/student/courses', 'Student::courses');
$routes->get('/student/grades', 'Student::grades');
$routes->get('/student/assignments', 'Student::assignments');
