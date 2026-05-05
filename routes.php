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

$router->get('/register', [RegisterController::class, 'create'])->middleware(GuestMiddleware::class);
$router->post('/register', [RegisterController::class, 'store'])->middleware(GuestMiddleware::class);

$router->get('/login', [LoginController::class, 'create'])->middleware(GuestMiddleware::class);
$router->post('/login', [LoginController::class, 'store'])->middleware(GuestMiddleware::class);

$router->get('/logout', [LoginController::class, 'destroy'])->middleware(AuthMiddleware::class);

$router->get('#/user/[0-9]+/post/[a-z]+#', function ($var1, $var2) {
    var_dump($var1, $var2);
});