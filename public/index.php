<?php

use App\Request;
use App\Routing\Router;

session_start();

require '../vendor/autoload.php';
require '../config/helpers.php';

$router = new Router();

require '../routes.php';

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Throwable $e) {
    http_response_code(500);
    if (Request::isAjax()) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => '500 Internal server error']);
    } else {
        template('errors/500');
    }
}