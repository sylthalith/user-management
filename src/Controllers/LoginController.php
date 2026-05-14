<?php

namespace App\Controllers;

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

        $stmt = db()->prepare('SELECT id, password FROM users WHERE email = :email');
        $stmt->execute(['email' => $_POST['email']]);

        $user = $stmt->fetch();

        if (!$user || !password_verify($_POST['password'], $user['password'])) {
            $errors = ['password' => 'Неверные данные пользователя'];
            template('login', ['errors' => $errors, 'email' => $_POST['email']]);
            return;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];

        redirect('/dashboard');
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

        session_destroy();

        redirect('/');
    }
}