<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->setAutoRoute(false);

// ── Public ────────────────────────────────────────────────────────────────────
$routes->get('/', 'Home::index');

// ── Auth ─────────────────────────────────────────────────────────────────────
$routes->get('/login',  'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// ── Admin ─────────────────────────────────────────────────────────────────────
$routes->get('/admin/dashboard', 'Admin::index', ['filter' => 'auth:admin']);

// Teachers
$routes->get('/admin/teachers',                        'Admin::teachers',              ['filter' => 'auth:admin']);
$routes->get('/admin/teachers/create',                 'Admin::createTeacher',         ['filter' => 'auth:admin']);
$routes->post('/admin/teachers/create',                'Admin::storeTeacher',          ['filter' => 'auth:admin']);
$routes->get('/admin/teachers/edit/(:num)',            'Admin::editTeacher/$1',        ['filter' => 'auth:admin']);
$routes->post('/admin/teachers/edit/(:num)',           'Admin::updateTeacher/$1',      ['filter' => 'auth:admin']);
$routes->get('/admin/teachers/toggle/(:num)',          'Admin::toggleTeacher/$1',      ['filter' => 'auth:admin']);
$routes->get('/admin/teachers/delete/(:num)',          'Admin::deleteTeacher/$1',      ['filter' => 'auth:admin']);
$routes->get('/admin/teachers/assign/(:num)',          'Admin::assignCourses/$1',      ['filter' => 'auth:admin']);
$routes->post('/admin/teachers/assign/(:num)',         'Admin::saveAssignments/$1',    ['filter' => 'auth:admin']);

// Students
$routes->get('/admin/students',                        'Admin::students',              ['filter' => 'auth:admin']);
$routes->get('/admin/students/create',                 'Admin::createStudent',         ['filter' => 'auth:admin']);
$routes->post('/admin/students/create',                'Admin::storeStudent',          ['filter' => 'auth:admin']);
$routes->get('/admin/students/edit/(:num)',            'Admin::editStudent/$1',        ['filter' => 'auth:admin']);
$routes->post('/admin/students/edit/(:num)',           'Admin::updateStudent/$1',      ['filter' => 'auth:admin']);
$routes->get('/admin/students/toggle/(:num)',          'Admin::toggleStudent/$1',      ['filter' => 'auth:admin']);
$routes->get('/admin/students/delete/(:num)',          'Admin::deleteStudent/$1',      ['filter' => 'auth:admin']);

// Courses
$routes->get('/admin/courses',                         'Admin::courses',               ['filter' => 'auth:admin']);
$routes->get('/admin/courses/create',                  'Admin::createCourse',          ['filter' => 'auth:admin']);
$routes->post('/admin/courses/create',                 'Admin::storeCourse',           ['filter' => 'auth:admin']);
$routes->get('/admin/courses/edit/(:num)',             'Admin::editCourse/$1',         ['filter' => 'auth:admin']);
$routes->post('/admin/courses/edit/(:num)',            'Admin::updateCourse/$1',       ['filter' => 'auth:admin']);
$routes->get('/admin/courses/toggle/(:num)',           'Admin::toggleCourse/$1',       ['filter' => 'auth:admin']);
$routes->get('/admin/courses/delete/(:num)',           'Admin::deleteCourse/$1',       ['filter' => 'auth:admin']);

// Categories
$routes->get('/admin/categories',                      'Admin::categories',            ['filter' => 'auth:admin']);
$routes->get('/admin/categories/create',               'Admin::createCategory',        ['filter' => 'auth:admin']);
$routes->post('/admin/categories/create',              'Admin::storeCategory',         ['filter' => 'auth:admin']);
$routes->get('/admin/categories/edit/(:num)',          'Admin::editCategory/$1',       ['filter' => 'auth:admin']);
$routes->post('/admin/categories/edit/(:num)',         'Admin::updateCategory/$1',     ['filter' => 'auth:admin']);
$routes->get('/admin/categories/delete/(:num)',        'Admin::deleteCategory/$1',     ['filter' => 'auth:admin']);

// Questions
$routes->get('/admin/questions',                       'Admin::questions',             ['filter' => 'auth:admin']);
$routes->get('/admin/questions/create',                'Admin::createQuestion',        ['filter' => 'auth:admin']);
$routes->post('/admin/questions/create',               'Admin::storeQuestion',         ['filter' => 'auth:admin']);
$routes->get('/admin/questions/edit/(:num)',           'Admin::editQuestion/$1',       ['filter' => 'auth:admin']);
$routes->post('/admin/questions/edit/(:num)',          'Admin::updateQuestion/$1',     ['filter' => 'auth:admin']);
$routes->get('/admin/questions/toggle/(:num)',         'Admin::toggleQuestion/$1',     ['filter' => 'auth:admin']);
$routes->get('/admin/questions/delete/(:num)',         'Admin::deleteQuestion/$1',     ['filter' => 'auth:admin']);

// ── Teacher ───────────────────────────────────────────────────────────────────
$routes->get('/teacher/dashboard', 'Teacher::dashboard', ['filter' => 'auth:teacher']);

// ── Student ───────────────────────────────────────────────────────────────────
$routes->get('/student/dashboard',                     'Student::dashboard',           ['filter' => 'auth:student']);
$routes->get('/student/evaluate',                      'Student::evaluate',            ['filter' => 'auth:student']);
$routes->get('/student/evaluate/(:num)/(:num)',        'Student::evaluateForm/$1/$2',  ['filter' => 'auth:student']);
$routes->post('/student/evaluate/(:num)/(:num)',       'Student::submitEvaluation/$1/$2', ['filter' => 'auth:student']);
$routes->get('/student/my-evaluations',                'Student::myEvaluations',       ['filter' => 'auth:student']);

// ── Catch-all — MUST stay last ────────────────────────────────────────────────
$routes->get('(:segment)', 'Pages::view');
