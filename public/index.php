<?php

use App\Container;
use App\Repositories\UserRepository;
use App\Routing\Router;

session_start();

require '../vendor/autoload.php';
require '../config/helpers.php';

try {
    $container = new Container();
    require '../config/container.php';

    $router = $container->get(Router::class);
    require '../routes.php';

    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Throwable $e) {
    abort(500, 'Ошибка на сервере');
}