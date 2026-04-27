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
// ── Teacher ───────────────────────────────────────────────────────────────────
$routes->get('/teacher/dashboard', 'Teacher::dashboard', ['filter' => 'auth:teacher']);

// ── Student ───────────────────────────────────────────────────────────────────
$routes->get('/student/dashboard', 'Student::dashboard', ['filter' => 'auth:student']);

// ── Catch-all — MUST stay last ────────────────────────────────────────────────
$routes->get('(:segment)', 'Pages::view');