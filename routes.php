<?php

use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\CsrfMiddleware;
use App\Middlewares\GuestMiddleware;
use App\Request;

$router->get('/', function() {
    template('welcome');
})->middleware(GuestMiddleware::class);

$router->get('/register', [RegisterController::class, 'create'])
       ->middleware(GuestMiddleware::class);

$router->post('/register', [RegisterController::class, 'store'])
       ->middleware([GuestMiddleware::class, CsrfMiddleware::class]);

$router->get('/login', [LoginController::class, 'create'])
       ->middleware(GuestMiddleware::class);

$router->post('/login', [LoginController::class, 'store'])
       ->middleware([GuestMiddleware::class, CsrfMiddleware::class]);

$router->get('/logout', [LoginController::class, 'destroy'])
       ->middleware(AuthMiddleware::class);

$router->get('/dashboard', function() {
    template('dashboard');
})->middleware(AuthMiddleware::class);

$router->get('/admin', function() {
    template('admin');
})->middleware(AuthMiddleware::class);