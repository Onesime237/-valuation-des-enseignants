<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->setAutoRoute(false);

// ── Public ────────────────────────────────────────────────────────────────────
$routes->get('/', 'Home::index');

// ── Auth ──────────────────────────────────────────────────────────────────────
$routes->get('/login',  'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// ── Admin ─────────────────────────────────────────────────────────────────────
$routes->get('/admin/dashboard', 'Admin::index', ['filter' => 'auth:admin']);

// Teachers
$routes->get('/admin/teachers',              'Admin::teachers',       ['filter' => 'auth:admin']);
$routes->get('/admin/teachers/create',       'Admin::createTeacher',  ['filter' => 'auth:admin']);
$routes->post('/admin/teachers/create',      'Admin::storeTeacher',   ['filter' => 'auth:admin']);
$routes->get('/admin/teachers/edit/(:num)',  'Admin::editTeacher/$1', ['filter' => 'auth:admin']);
$routes->post('/admin/teachers/edit/(:num)', 'Admin::updateTeacher/$1', ['filter' => 'auth:admin']);
$routes->get('/admin/teachers/toggle/(:num)','Admin::toggleTeacher/$1', ['filter' => 'auth:admin']);
$routes->get('/admin/teachers/delete/(:num)','Admin::deleteTeacher/$1', ['filter' => 'auth:admin']);

// Students
$routes->get('/admin/students',              'Admin::students',       ['filter' => 'auth:admin']);
$routes->get('/admin/students/create',       'Admin::createStudent',  ['filter' => 'auth:admin']);
$routes->post('/admin/students/create',      'Admin::storeStudent',   ['filter' => 'auth:admin']);
$routes->get('/admin/students/edit/(:num)',  'Admin::editStudent/$1', ['filter' => 'auth:admin']);
$routes->post('/admin/students/edit/(:num)', 'Admin::updateStudent/$1', ['filter' => 'auth:admin']);
$routes->get('/admin/students/toggle/(:num)','Admin::toggleStudent/$1', ['filter' => 'auth:admin']);
$routes->get('/admin/students/delete/(:num)','Admin::deleteStudent/$1', ['filter' => 'auth:admin']);

// ── Teacher ───────────────────────────────────────────────────────────────────
$routes->get('/teacher/dashboard', 'Teacher::dashboard', ['filter' => 'auth:teacher']);

// ── Student ───────────────────────────────────────────────────────────────────
$routes->get('/student/dashboard', 'Student::dashboard', ['filter' => 'auth:student']);

// ── Catch-all — MUST stay last ────────────────────────────────────────────────
$routes->get('(:segment)', 'Pages::view');