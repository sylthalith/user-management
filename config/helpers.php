<?php

use App\Database;

define('ROOT', dirname(__DIR__));
define('TEMPLATES', ROOT . '/templates');
define('STYLES', '/css');
define('CONFIG', ROOT . '/config');

function template(string $template, array $data = []) {
    require TEMPLATES . '/' . $template . '.php';
}

function style($style) {
    return STYLES . '/' . $style . '.css';
}

function config($conf) {
    return CONFIG . '/' . $conf . '.php';
}

function db() {
    return Database::get();
}

function redirect($path) {
    header('Location: ' . ROOT . $path);
}

function dd($value) {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}