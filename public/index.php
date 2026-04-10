<?php

use App\Database;
use App\Router;

session_start();

require '../vendor/autoload.php';
require '../config/helpers.php';

$router = new Router();
require '../routes.php';

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);