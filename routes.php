<?php

use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\UserController;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Profile\PasswordController;
use App\Controllers\Profile\ProfileController;
use App\Middlewares\AdminMiddleware;
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


$router->get('/admin/dashboard', [DashboardController::class, 'index'])
       ->middleware(AdminMiddleware::class);

$router->get('/admin/users', [UserController::class, 'index'])
       ->middleware(AdminMiddleware::class);

$router->get('/admin/users/{id}', [UserController::class, 'show']);