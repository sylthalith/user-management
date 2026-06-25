<?php

namespace App\Security;

use App\Repositories\RememberTokenRepository;
use App\Repositories\UserRepository;

class Auth
{
    public function __construct(
        private RememberTokenRepository $tokens,
        private UserRepository $users
    ) {}

    public function check(): bool
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }

        if (!isset($_COOKIE['remember_token'])) {
            return false;
        }

        $rememberToken = $_COOKIE['remember_token'];

        $data = $this->tokens->findOne(['token' => $rememberToken]);

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

    public function user(): ?array
    {
        return $this->check() ? $this->users->findOne(['id' => $_SESSION['user_id']])
                              : null;
    }

    public function isAdmin(): bool
    {
        return $this->user()['is_admin'] ?? false;
    }
}