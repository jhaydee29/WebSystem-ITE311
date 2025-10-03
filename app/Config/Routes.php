<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');

$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Auth::dashboard');

// Role-specific management routes (placeholders for future implementation)
$routes->get('/admin/users', 'Admin::users');
$routes->get('/admin/courses', 'Admin::courses');
$routes->get('/admin/reports', 'Admin::reports');
$routes->get('/admin/settings', 'Admin::settings');

$routes->get('/teacher/courses', 'Teacher::courses');
$routes->get('/teacher/gradebook', 'Teacher::gradebook');
$routes->get('/teacher/assignments', 'Teacher::assignments');
$routes->get('/teacher/students', 'Teacher::students');

$routes->get('/student/courses', 'Student::courses');
$routes->get('/student/grades', 'Student::grades');
$routes->get('/student/assignments', 'Student::assignments');
$routes->get('/student/resources', 'Student::resources');