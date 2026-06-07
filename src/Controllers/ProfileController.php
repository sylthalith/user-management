<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Request;
use App\Security\Auth;

class ProfileController
{
    public function show()
    {
        template('profile/show', ['user' => Auth::user()]);
    }

    public function edit()
    {
        template('profile/edit', ['user' => Auth::user()]);
    }

    public function update()
    {
        $user = Auth::user();

        $validation = Request::validate(rules: [
            'name' => "required|min:5|max:50|unique:users,name,${user['name']}",
            'phone' => "required|phone|unique:users,phone,${user['phone']}",
            'email' => "required|email|unique:users,email,${user['email']}",
        ]);

        if (!$validation) {
            $errors = Request::validationErrors();

            $old = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
            ];

            template('profile/edit', [
                'errors' => $errors,
                'old' => $old,
            ]);

            return;
        }

        $id = Auth::userId();

        UserRepository::updateById($id, [
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email']
        ]);

        // flash-сообщение
        template('profile/show', ['user' => Auth::user()]);
    }
}