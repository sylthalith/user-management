<?php

namespace App\Controllers;

class RegisterController
{
    public function create() {
        template('register');
    }

    public function store() {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];


    }
}