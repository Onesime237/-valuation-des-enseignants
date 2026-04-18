<?php

use App\Controllers\News;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
/**
 * @var RouteCollection $routes
 */
$routes->get('news', [News::class, 'index']);  
$routes->get('news/new', [News::class, 'new']);
$routes->post('news', [News::class, 'create']);
$routes->get('news/(:segment)', [News::class, 'show']);

// 👉 TA PAGE D'ACCUEIL
$routes->get('/', 'Home::index');   // page d'accueil
$routes->get('/login', 'Auth::index'); // connexion


$routes->get('/login', 'Auth::login');
// Teacher
$routes->get('/teacher/login', 'Teacher::login');
// Admin
$routes->get('/admin/login', 'Admin::login');

// autres routes
$routes->get('pages', [Pages::class, 'index']);
$routes->get('/student/profile', 'Student::profile');   // afficher page
$routes->post('/student/profile', 'Student::profile'); // traiter données
$routes->post('/student/teachers', 'Student::teachers');
$routes->get('/student/teachers', 'Student::teachers');
$routes->get('/student/evaluate/(:num)', 'Student::evaluate/$1');
// ⚠️ TOUJOURS EN DERNIER
$routes->get('(:segment)', [Pages::class, 'view']);


