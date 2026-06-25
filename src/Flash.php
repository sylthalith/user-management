<?php

namespace App;

class Flash
{
    private string $key = 'flash';

    public function set(string $message)
    {
        $_SESSION[$this->key] = $message;
    }

    public function get(): ?string
    {
        $message = $_SESSION[$this->key] ?? null;

        unset($_SESSION[$this->key]);

        return $message;
    }
}