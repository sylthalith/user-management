<?php

namespace App\Controllers;

class RegisterController
{
    public function create() {
        template('register');
    }

    public function store() {
        // Проверка уникальности name, phone, email в БД
        $validation = validate($_POST, [
            'name' => 'required|min:5|max:50',
            'phone' => 'required|phone',
            'email' => 'required|email',
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors()->toArray();
            template('register', ['errors' => $errors]);
            return;
        }
    }
}