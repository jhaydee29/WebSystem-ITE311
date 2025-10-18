<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
<<<<<<< HEAD

// Public routes
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');

// Announcement routes
$routes->group('announcements', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'Announcement::index');
    
    // Protected routes (admin only)
    $routes->group('', ['filter' => 'auth:admin'], function($routes) {
        $routes->get('create', 'Announcement::create');
        $routes->post('store', 'Announcement::store');
        $routes->get('edit/(:num)', 'Announcement::edit/$1');
        $routes->post('update/(:num)', 'Announcement::update/$1');
        $routes->get('delete/(:num)', 'Announcement::delete/$1');
    });
});

// Authentication routes
$routes->group('', ['namespace' => 'App\Controllers'], function($routes) {
    // Registration
    $routes->get('/register', 'Auth::register');
    $routes->post('/register', 'Auth::register');
    
    // Login/Logout
    $routes->get('/login', 'Auth::login');
    $routes->post('/login', 'Auth::login');
    $routes->get('/logout', 'Auth::logout');
    
    // Dashboard routes
    $routes->group('', ['filter' => 'auth'], function($routes) {
        // Student dashboard (announcements page)
        $routes->get('/dashboard', 'Auth::dashboard');
        
        // Teacher dashboard
        $routes->group('', ['filter' => 'role:teacher'], function($routes) {
            $routes->get('teacher/dashboard', 'Teacher::dashboard');
        });
        
        // Admin dashboard
        $routes->group('', ['filter' => 'role:admin'], function($routes) {
            $routes->get('admin/dashboard', 'Admin::dashboard');
        });
    });
});

// Course routes
$routes->group('', ['namespace' => 'App\Controllers'], function($routes) {
    // Course listing
    $routes->get('/courses', 'Course::index');
    
    // Course details
    $routes->get('/course/(:num)', 'Course::view/$1');
    
    // Course enrollment
    $routes->post('/course/enroll', 'Course::enroll');
    
    // Protected course management routes (future implementation)
    $routes->group('', ['filter' => 'auth'], function($routes) {
        $routes->get('/course/create', 'Course::create');
        $routes->post('/course/store', 'Course::store');
        $routes->get('/course/edit/(:num)', 'Course::edit/$1');
        $routes->post('/course/update/(:num)', 'Course::update/$1');
        $routes->post('/course/delete/(:num)', 'Course::delete/$1');
    });
});

// Admin routes
$routes->group('admin', ['namespace' => 'App\Controllers', 'filter' => 'auth:admin'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('users', 'Admin::users');
    $routes->get('courses', 'Admin::courses');
    $routes->get('reports', 'Admin::reports');
    $routes->get('settings', 'Admin::settings');
});

// Teacher routes
$routes->group('teacher', ['namespace' => 'App\Controllers', 'filter' => 'auth:teacher'], function($routes) {
    $routes->get('dashboard', 'Teacher::dashboard');
    $routes->get('courses', 'Teacher::courses');
    $routes->get('gradebook', 'Teacher::gradebook');
    $routes->get('assignments', 'Teacher::assignments');
    $routes->get('students', 'Teacher::students');
});

// Student routes
$routes->group('student', ['namespace' => 'App\Controllers', 'filter' => 'auth:student'], function($routes) {
    $routes->get('dashboard', 'Student::dashboard');
    $routes->get('courses', 'Student::courses');
    $routes->get('grades', 'Student::grades');
    $routes->get('assignments', 'Student::assignments');
    $routes->get('profile', 'Student::profile');
});
=======
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/courses', 'Course::index');
$routes->post('/course/enroll', 'Course::enroll');
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
$routes->get('/courses', 'Course::index');
>>>>>>> 4ea0f464c41604ac8b9ef56ccd448fdc7b56931e
