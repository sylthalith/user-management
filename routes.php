<?php

use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\CsrfMiddleware;
use App\Middlewares\GuestMiddleware;
use App\Request;

$router->get('/', function() {
    template('main');
})->middleware(GuestMiddleware::class);

$router->get('/dashboard', function () {
    echo $_SESSION['user_id'];
})->middleware(AuthMiddleware::class);

$router->get('/register', [RegisterController::class, 'create'])
       ->middleware(GuestMiddleware::class);

$router->post('/register', [RegisterController::class, 'store'])
       ->middleware([GuestMiddleware::class, CsrfMiddleware::class]);

$router->get('/login', [LoginController::class, 'create'])
       ->middleware(GuestMiddleware::class);

$router->post('/login', [LoginController::class, 'store'])
       ->middleware([GuestMiddleware::class, CsrfMiddleware::class]);

$router->get('/logout', [LoginController::class, 'destroy'])
       ->middleware(AuthMiddleware::class);

$router->get('/test', function() {
    if (Request::isAjax()) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['data' => 'ajax']);
    } else {
        template('errors/404');
        die();
    }
});

$router->post('/test', function () {
    if (Request::isAjax()) {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['data' => $data]);
    } else {
        template('errors/404');
        die();
    }
})->middleware(CsrfMiddleware::class);