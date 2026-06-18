<?php

use App\Request;
use App\Routing\Router;

session_start();

require '../vendor/autoload.php';
require '../config/helpers.php';

//dd(user()['avatar']);

$router = new Router();

require '../routes.php';

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

//try {
//    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
//} catch (Throwable $e) {
//    abort(500, 'Ошибка на сервере');
//}