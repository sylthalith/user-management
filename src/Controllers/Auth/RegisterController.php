<?php

namespace App\Controllers\Auth;

use App\Repositories\UserRepository;
use App\Validation\Validator;

class RegisterController
{
    public function __construct(
        private Validator $validator,
        private UserRepository $users,
    ) {}

    public function create() {
        template('register');
    }

    public function store() {
        $this->validator->validate($_POST, [
            'name' => 'required|min:5|max:50|unique:users,name',
            'phone' => 'required|phone|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($this->validator->hasErrors()) {
            $errors = $this->validator->getErrors();

            $old = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
            ];

            template('register', [
                'errors' => $errors,
                'old' => $old,
            ]);

            return;
        }

        $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);

        $userId = $this->users->create([
            'name' => $_POST['name'],
            'phone' => $phone,
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);

        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;

        redirect('/profile');
    }
}