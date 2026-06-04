<?php

namespace App\Controllers;

use App\Repositories\RememberTokenRepository;
use App\Repositories\UserRepository;
use App\Request;

class LoginController
{
    public function create() {
        template('login');
    }

    public function store() {
        $validation = Request::validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$validation) {
            $errors = Request::validationErrors();
            template('login', ['errors' => $errors, 'email' => $_POST['email']]);
            return;
        }

        $user = UserRepository::findByEmail($_POST['email']);

        if (!$user || !password_verify($_POST['password'], $user['password'])) {
            $errors = ['password' => 'Неверные данные пользователя'];
            template('login', ['errors' => $errors, 'email' => $_POST['email']]);
            return;
        }

        if (isset($_POST['remember_me'])) {
            $rememberToken = bin2hex(random_bytes(32));
            $expiresAt = strtotime('+30 days');

            setcookie('remember_token', $rememberToken, [
                'expires' => $expiresAt,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Strict'
            ]);

            RememberTokenRepository::create([
                'id' => $user['id'],
                'token' => $rememberToken,
                'expires_at' => date("Y-m-d H:i:s", $expiresAt)
            ]);
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];

        redirect('/profile');
    }

    public function destroy() {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        if (isset($_COOKIE['remember_token'])) {
            $rememberToken = $_COOKIE['remember_token'];

            RememberTokenRepository::deleteByToken($rememberToken);
        }

        setcookie('remember_token', '', time() - 3600, '/');

        session_destroy();

        redirect('/');
    }
}