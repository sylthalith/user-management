<?php

namespace App\Controllers;

use App\Validator;

class RegisterController
{
    public function create() {
        template('register');
    }

    public function store() {
//        Validator::validate($_POST, [
//            'name' => ['required', 'min:5', 'max:255'],
//            'phone' => ['required', 'phone', 'unique:users'],
//            'email' => ['required', 'email', 'unique:users', 'min:5', 'max:255'],
//            'password' => ['required', 'min:8', 'max:255'],
//        ]);


        $errors = [];
        if (empty($name)) {
            $errors['name'] = "";
        }

        if ($password1 != $password2) {
            $SESSION['errors']['password'] = 'Пароли не совпадают';
//            redirect('/register');
        }
    }
}