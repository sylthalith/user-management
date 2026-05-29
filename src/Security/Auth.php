<?php

namespace App\Security;

use PDO;

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

        $stmt = db()->prepare('SELECT user_id, token, expires_at FROM remember_tokens WHERE token = :token LIMIT 1');
        $stmt->execute(['token' => $rememberToken]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

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
}