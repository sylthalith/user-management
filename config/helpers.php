<?php

use App\Database;
use App\Middlewares\CsrfMiddleware;
use Rakit\Validation\Validator;
use App\Security\CsrfToken;

define('ROOT', dirname(__DIR__));
define('TEMPLATES', ROOT . '/templates');
define('STYLES', '/css');
define('CONFIG', ROOT . '/config');
define('VALIDATION', ROOT . '/src/Validation');

function template(string $template, array $data = []) {
    extract($data);

    require TEMPLATES . "/$template.php";
}

function style(string $style) {
    return STYLES . "/$style.css";
}

function config(string $conf) {
    return CONFIG . "/$conf.php";
}

function db() {
    return Database::get();
}

function redirect($path) {
    header("Location: $path");
}

function dd($value) {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

function partial($partial, $data = []) {
    extract($data);
    require TEMPLATES . "/partials/$partial.php";
}

function csrf_token() {
    return (new CsrfToken())->get();
}