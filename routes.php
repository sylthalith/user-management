<?php

use App\Controllers\LoginController;
use App\Controllers\PasswordController;
use App\Controllers\ProfileController;
use App\Controllers\RegisterController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\CsrfMiddleware;
use App\Middlewares\GuestMiddleware;

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

$router->get('/profile', [ProfileController::class, 'show'])
       ->middleware(AuthMiddleware::class);

$router->get('/profile/edit', [ProfileController::class, 'edit'])
       ->middleware(AuthMiddleware::class);

$router->post('/profile/edit', [ProfileController::class, 'update'])
       ->middleware([AuthMiddleware::class, CsrfMiddleware::class]);

$router->get('/password/change', [PasswordController::class, 'create'])
       ->middleware(AuthMiddleware::class);

$router->post('/password/change', [PasswordController::class, 'store'])
       ->middleware([AuthMiddleware::class, CsrfMiddleware::class]);

$router->get('/admin', function() {
    template('admin');
})->middleware(AuthMiddleware::class);
