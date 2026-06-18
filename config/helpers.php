<?php

use App\Database;
use App\Flash;
use App\Middlewares\CsrfMiddleware;
use App\Request;
use App\Security\Auth;
use Rakit\Validation\Validator;
use App\Security\CsrfToken;

define('ROOT', dirname(__DIR__));
define('TEMPLATES', ROOT . '/templates');
define('STYLES_URL', '/css');
define('SCRIPTS_URL', '/js');
define('CONFIG', ROOT . '/config');
define('VALIDATION', ROOT . '/src/Validation');
define('AVATARS', ROOT . '/public/avatars');

function template(string $template, array $data = []) {
    extract($data);

    require TEMPLATES . "/$template.php";
}

function partial(string $partial, array $data = []) {
    template("partials/$partial", $data);
}

function getFilesPaths(array|string $files, string $folderPath, string $extension) {
    $paths = [];
    foreach (wrapArray($files) as $file) {
        $paths[] = $folderPath . "/$file.$extension";
    }
    return $paths;
}

function styles(array|string $styles) {
    return getFilesPaths($styles, STYLES_URL, 'css');
}

function scripts(array|string $scripts) {
    return getFilesPaths($scripts, SCRIPTS_URL, 'js');
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

function csrfToken(): string {
    $token = (new CsrfToken())->get();
    return "<input type='hidden' name='csrf_token' value='$token'>";
}

function wrapArray($value) {
    return !is_array($value) ? [$value] : $value;
}

function h(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function isAuth(): bool {
    return Auth::check();
}

function user(): array {
    return Auth::user();
}

function abort($code, $message) {
    http_response_code($code);

    if (Request::isAjax()) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => $message]);
    } else {
        template('error', ['code' => $code, 'message' => $message]);
    }

    die();
}

function getFlashMessage(): ?string
{
    return Flash::get();
}

function avatarSrc(?string $avatar): string {
    return $avatar ? "/avatars/$avatar" : '/avatars/default.jpg';
}