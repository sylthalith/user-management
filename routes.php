<?php

use App\Controllers\RegisterController;

$router->get('/', function () {
    echo 'Hello World!';
});

$router->get('/register', [RegisterController::class, 'create']);

$router->post('/register', [RegisterController::class, 'store']);