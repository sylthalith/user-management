<?php

use App\Controllers\RegisterController;

$router->get('/', function () {
    echo $_SESSION['user_id'];
});

$router->get('/register', [RegisterController::class, 'create']);

$router->post('/register', [RegisterController::class, 'store']);