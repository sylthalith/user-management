<?php

namespace App\Controllers;

use Rakit\Validation\Validator;

class RegisterController
{
    public function create() {
        template('register');
    }

    public function store() {
        $validation = validate($_POST, [
            'name' => 'required|min:5|max:50',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
            dd($errors->firstOfAll());
        }
    }
}