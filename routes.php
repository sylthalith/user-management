<?php

use App\Controllers\RegisterController;

$router->addRoute('GET', '/', function () {
    $stmt = db()->prepare('SELECT * FROM `users`');
    $stmt->execute();
    $users = $stmt->fetchAll();
    var_dump($users);
});

$router->addRoute('GET', '/register', [RegisterController::class, 'create']);

$router->addRoute('POST', '/register', [RegisterController::class, 'store']);