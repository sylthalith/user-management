<?php

use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

$router->get('/', function () {
    echo 'Главная страница';
})->middleware(GuestMiddleware::class);

$router->get('/dashboard', function () {
    echo $_SESSION['user_id'];
})->middleware(AuthMiddleware::class);

$router->get('/register', [RegisterController::class, 'create']);
$router->post('/register', [RegisterController::class, 'store']);

$router->get('/login', [LoginController::class, 'create']);
$router->post('/login', [LoginController::class, 'store']);

$router->get('/logout', [LoginController::class, 'destroy']);