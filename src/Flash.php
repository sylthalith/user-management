<?php

namespace App;

class Flash
{
    public static function set(string $message)
    {
        $_SESSION['flash'] = $message;
    }

    public static function get(): ?string
    {
        $message = $_SESSION['flash'] ?? null;

        unset($_SESSION['flash']);

        return $message;
    }
}