<?php

namespace App\Controllers;

class LoginController
{
    public function create() {
        template('login');
    }

    public function store() {
        $validation = validate($_POST, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors()->toArray();
            template('login', ['errors' => $errors]);
            return;
        }

        $stmt = db()->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $_POST['email']]);

        $user = $stmt->fetch();

        if (!$user) {
            $errors = ['email' => 'Пользователя с такой почтой не существует'];
            template('login', ['errors' => $errors]);
            return;
        };

        if (!password_verify($_POST['password'], $user['password'])) {
            $errors = ['password' => 'Неверный пароль'];
            template('login', ['errors' => $errors]);
            return;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];

        redirect('/');
    }
}