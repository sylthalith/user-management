<?php

namespace App\Security;

use App\Repositories\RememberTokenRepository;
use App\Repositories\UserRepository;

class Auth
{
    public static function check(): bool
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }

        if (!isset($_COOKIE['remember_token'])) {
            return false;
        }

        $rememberToken = $_COOKIE['remember_token'];

        $data = RememberTokenRepository::findByToken($rememberToken);

        if (!$data) {
            return false;
        }

        $expiresAt = strtotime($data['expires_at']);

        if ($expiresAt <= time()) {
            return false;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $data['user_id'];

        return true;
    }

    public static function user(): ?array
    {
        return UserRepository::findById($_SESSION['user_id']);
    }

    public static function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }
}