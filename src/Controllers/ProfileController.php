<?php

namespace App\Controllers;

use App\Flash;
use App\Repositories\UserRepository;
use App\Request;
use App\Security\Auth;

class ProfileController
{
    public function show()
    {
        template('profile/show', ['old' => Auth::user()]);
    }

    public function edit()
    {
        template('profile/edit', ['old' => Auth::user()]);
    }

    public function update()
    {
        $user = Auth::user();

        $validation = Request::validate(rules: [
            'name' => "required|min:5|max:50|unique:users,name,{$user['name']}",
            'phone' => "required|phone|unique:users,phone,{$user['phone']}",
            'email' => "required|email|unique:users,email,{$user['email']}",
        ]);

        $avatarLoaded = $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE;

        if ($avatarLoaded) {
            if ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
                $avatarErrorMessage = 'Ошибка загрузки аватарки';
            } elseif ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
                $avatarErrorMessage = 'Размер аватарки не должен превышать 2МБ';
            } else {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

                $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
                $mime = mime_content_type($_FILES['avatar']['tmp_name']);

                if (!in_array($extension, $allowedExtensions) || !in_array($mime, $allowedMimes)) {
                    $avatarErrorMessage = 'Расширение аватарки должно быть jpg, jpeg, png, webp';
                }
            }
        }

        if (!$validation || isset($avatarErrorMessage)) {
            $errors = Request::validationErrors();

            $old = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
            ];

            if (isset($avatarErrorMessage)) {
                Flash::set($avatarErrorMessage);
            }

            template('profile/edit', [
                'errors' => $errors,
                'old' => $old,
            ]);

            return;
        }

        $profileUpdated = false;

        if ($avatarLoaded) {
            $fileName = uniqid() . ".$extension";
            $filePath = AVATARS . "/$fileName";

            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)) {
                Flash::set('Не удалось сохранить аватар');

                redirect('/profile');

                return;
            }

            UserRepository::updateById($user['id'], ['avatar' => $fileName]);

            if ($user['avatar']) {
                unlink(AVATARS . '/' . $user['avatar']);
            }

            $profileUpdated = true;
        }

        $data = array_filter([
            'name' => $_POST['name'] !== $user['name'] ? $_POST['name'] : null,
            'phone' => $_POST['phone'] !== $user['phone'] ? $_POST['phone'] : null,
            'email' => $_POST['email'] !== $user['email'] ? $_POST['email'] : null,
        ]);

        if (!empty($data)) {
            UserRepository::updateById($user['id'], $data);

            $profileUpdated = true;
        }

        if ($profileUpdated) {
            Flash::set('Данные профиля изменены');
        }

        redirect('/profile');
    }
}