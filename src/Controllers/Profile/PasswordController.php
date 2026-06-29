<?php

namespace App\Controllers\Profile;

use App\Flash;
use App\Repositories\UserRepository;
use App\Security\Auth;
use App\Validation\Validator;

class PasswordController
{
    public function __construct(
        private Validator $validator,
        private Auth $auth,
        private UserRepository $users,
        private Flash $flash,
    ) {}

    public function create()
    {
        template('password-change');
    }

    public function store()
    {
        $this->validator->validate($_POST, [
            'current_password' => 'required',
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($this->validator->hasErrors()) {
            $errors = $this->validator->getErrors();

            template('password-change', ['errors' => $errors]);

            return;
        }

        $user = $this->auth->user();

        $currentPassword = $_POST['current_password'];
        $userPassword = $user['password'];

        if (!password_verify($currentPassword, $userPassword)) {
            $errors = [
                'current_password' => 'Неверный пароль',
            ];

            template('password-change', ['errors' => $errors]);

            return;
        }

        $this->users->update(
            ['id' => $user['id']],
            ['password' => password_hash($_POST['password'], PASSWORD_DEFAULT)]
        );

        $this->flash->set('Пароль успешно изменен');

        redirect('/profile');
    }
}