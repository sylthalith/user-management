<?php

use App\Controllers\RegisterController;
use App\Validator;

//        Validator::validate($_POST, [
//            'name' => ['required', 'min:5', 'max:255'],
//            'phone' => ['required', 'phone', 'unique:users'],
//            'email' => ['required', 'email', 'unique:users', 'min:5', 'max:255'],
//            'password' => ['required', 'min:8', 'max:255'],
//        ]);

$router->addRoute('GET', '/', function () {
    $data = [
        'password' => '123456789',
        'password_confirmation' => '123456789',
    ];

    $validator = new Validator($data, [
//        'name' => ['required', 'min:5', 'max:255'],
//        'phone' => ['required', 'phone', 'unique:users'],
//        'email' => ['required', 'email', 'unique:users', 'min:5', 'max:255'],
//        'password' => ['required', 'min:8', 'max:255'],
        'password' => ['required', 'confirmed', 'min:8', 'max:255'],
    ]);

    $validator->validate();

    dd($validator->getErrors());
});

$router->addRoute('GET', '/register', [RegisterController::class, 'create']);

$router->addRoute('POST', '/register', [RegisterController::class, 'store']);