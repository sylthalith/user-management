<?php

use App\Container;
use App\Flash;
use App\Request;
use App\Security\Auth;
use App\Security\CsrfToken;

define('ROOT', dirname(__DIR__));
define('TEMPLATES', ROOT . '/templates');
define('STYLES_URL', '/css');
define('SCRIPTS_URL', '/js');
define('CONFIG', ROOT . '/config');
define('VALIDATION', ROOT . '/src/Validation');
define('AVATARS', ROOT . '/public/avatars');

function container(): Container
{
    global $container;

    return $container;
}

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
    $token = container()->get(CsrfToken::class)->get();

    return "<input type='hidden' name='csrf_token' value='$token'>";
}

function wrapArray($value) {
    return !is_array($value) ? [$value] : $value;
}

function h(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function isAuth(): bool
{
    return container()->get(Auth::class)->check();
}

function user(): ?array
{
    return container()->get(Auth::class)->user();
}

function isAdmin(): bool
{
    return container()->get(Auth::class)->isAdmin();
}

function abort($code, $message) {
    http_response_code($code);

    $request = container()->get(Request::class);

    if ($request->isAjax()) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => $message]);
    } else {
        template('error', ['code' => $code, 'message' => $message]);
    }

    die();
}

function getFlashMessage(): ?string
{
    $flash = container()->get(Flash::class);

    return $flash->get();
}

function avatarSrc(?string $avatar): string {
    return $avatar ? "/avatars/$avatar" : '/avatars/default.jpg';
}