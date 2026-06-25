<?php

use App\Container;
use App\Routing\Router;

session_start();

require '../vendor/autoload.php';

$container = new Container();

require '../config/container.php';
require '../config/helpers.php';

$router = $container->get(Router::class);

require '../routes.php';

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

//try {
//    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
//} catch (Throwable $e) {
//    abort(500, 'Ошибка на сервере');
//}