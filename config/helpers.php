<?php

use App\Database;
use App\Middlewares\CsrfMiddleware;
use Rakit\Validation\Validator;
use App\Security\CsrfToken;

define('ROOT', dirname(__DIR__));
define('TEMPLATES', ROOT . '/templates');
define('STYLES_URL', '/css');
define('SCRIPTS_URL', '/js');
define('CONFIG', ROOT . '/config');
define('VALIDATION', ROOT . '/src/Validation');

function template(string $template, array $data = []) {
    extract($data);

    require TEMPLATES . "/$template.php";
}

function style(string $style) {
    return STYLES_URL . "/$style.css";
}

function script(string $script) {
    return SCRIPTS_URL . "/$script.js";
}

function config(string $conf) {
    return CONFIG . "/$conf.php";
}

function db() {
    return Database::get();
}

function redirect($path) {
    header("Location: $path");
    exit();
}

function dd($value) {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

function csrf_token() {
    return (new CsrfToken())->get();
}

function wrap_array($value) {
    return !is_array($value) ? [$value] : $value;
}

function h(string $str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function isAuth() {
    return isset($_SESSION['user_id']);
}