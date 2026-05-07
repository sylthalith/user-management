<?php

use App\Database;
use Rakit\Validation\Validator;
use App\Security\CsrfToken;

define('ROOT', dirname(__DIR__));
define('TEMPLATES', ROOT . '/templates');
define('STYLES', '/css');
define('CONFIG', ROOT . '/config');

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

function validate($data, $rules) {
    $messages = require CONFIG . '/validation/messages.php';
    $aliases = require CONFIG . '/validation/aliases.php';

    $validator = new Validator;

    $customRules = require ROOT . '/src/Validation/rules.php';
    foreach ($customRules as $rule => $class) {
        $validator->addValidator($rule, new $class());
    }

    $validation = $validator->make($data, $rules, $messages);
    $validation->setAliases($aliases);

    $validation->validate();

    return $validation;
}

function partial($partial, $data = []) {
    extract($data);
    require TEMPLATES . "/partials/$partial.php";
}

function csrf_token() {
    return (new CsrfToken())->get();
}