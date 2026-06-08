<?php

namespace App\Controllers;

use App\Flash;
use App\Repositories\UserRepository;
use App\Request;
use App\Security\Auth;

class PasswordController
{
    public function create()
    {
        template('password-change');
    }

    public function store()
    {
        $validation = Request::validate([
            'current_password' => 'required',
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|same:password',
        ]);

        if (!$validation) {
            $errors = Request::validationErrors();

            template('password-change', ['errors' => $errors]);

            return;
        }

        $currentPassword = $_POST['current_password'];
        $userPassword = Auth::user()['password'];

        if (!password_verify($currentPassword, $userPassword)) {
            $errors = [
                'current_password' => 'Неверный пароль',
            ];

            template('password-change', ['errors' => $errors]);

            return;
        }

        $id = Auth::userId();

        UserRepository::updateById($id, [
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        ]);

        Flash::set('Пароль успешно изменен');

        redirect('/profile');
    }
}