<?php

use App\Controllers\LoginController;
use App\Controllers\RegisterController;

$router->get('/', function () {
    echo 'Главная страница';
});

$router->get('/dashboard', function () {
    echo $_SESSION['user_id'];
});

$router->get('/register', [RegisterController::class, 'create']);
$router->post('/register', [RegisterController::class, 'store']);

$router->get('/login', [LoginController::class, 'create']);
$router->post('/login', [LoginController::class, 'store']);

$router->get('/logout', [LoginController::class, 'destroy']);