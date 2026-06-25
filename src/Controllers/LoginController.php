<?php

namespace App\Controllers;

use App\Flash;
use App\Repositories\RememberTokenRepository;
use App\Repositories\UserRepository;
use App\Validation\Validator;

class LoginController
{
    public function __construct(
        private Validator $validator,
        private UserRepository $users,
        private RememberTokenRepository $tokens,
        private Flash $flash,
    ) {}

    public function create() {
        template('login');
    }

    public function store() {
        $this->validator->validate($_POST, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($this->validator->hasErrors()) {
            $errors = $this->validator->getErrors();
            $old = ['email' => $_POST['email']];

            template('login', ['errors' => $errors, 'old' => $old]);
            return;
        }

        $user = $this->users->findOne(['email' => $_POST['email']]);

        if (!$user || !password_verify($_POST['password'], $user['password'])) {
            $errors = ['password' => 'Неверные данные пользователя'];
            $old = ['email' => $_POST['email']];

            template('login', ['errors' => $errors, 'old' => $old]);

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

            $this->tokens->create([
                'user_id' => $user['id'],
                'token' => $rememberToken,
                'expires_at' => date("Y-m-d H:i:s", $expiresAt)
            ]);
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];

        $this->flash->set("Привет, {$user['name']}!");

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

            $this->tokens->delete(['token' => $rememberToken]);
        }

        setcookie('remember_token', '', time() - 3600, '/');

        session_destroy();

        redirect('/');
    }
}