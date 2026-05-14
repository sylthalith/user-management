<?php

namespace App\Controllers;

use App\Request;

class RegisterController
{
    public function create() {
        template('register');
    }

    public function store() {
        $validation = Request::validate([
            'name' => 'required|min:5|max:50|unique:users,name',
            'phone' => 'required|phone|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|same:password'
        ]);

        if (!$validation) {
            $errors = Request::validationErrors();
            template('register', ['errors' => $errors, 'name' => $_POST['name'], 'phone' => $_POST['phone'], 'email' => $_POST['email']]);
            return;
        }

        $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);

        $stmt = db()->prepare(
            'INSERT INTO users (name, phone, email, password) VALUES (:name, :phone, :email, :password)'
        );

        $stmt->execute([
            'name' => $_POST['name'],
            'phone' => $phone,
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);

        session_regenerate_id(true);
        $_SESSION['user_id'] = db()->lastInsertId();

        redirect('/dashboard');
    }
}