<?php

namespace App\Controllers;

class PasswordController
{
    public function create()
    {
        template('password-change');
    }

    public function store()
    {
        dd($_POST);
    }
}