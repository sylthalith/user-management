<?php

namespace App\Repositories;

use PDO;

class RememberTokenRepository
{
    public static function create(int $userId, string $token, string $expiresAt): int
    {
        $stmt = db()->prepare('INSERT INTO remember_tokens (user_id, token, expires_at) 
                                   VALUES (:user_id, :token, :expires_at)');

        $stmt->execute([
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => $expiresAt
        ]);

        return (int) db()->lastInsertId();
    }

    public static function findByToken(string $token): ?array
    {
        $stmt = db()->prepare('SELECT * FROM remember_tokens WHERE token = :token LIMIT 1');
        $stmt->execute(['token' => $token]);
        return $stmt->fetch() ?: null;
    }

    public static function deleteByToken(string $token): void
    {
        $stmt = db()->prepare('DELETE FROM remember_tokens WHERE token = :token');
        $stmt->execute(['token' => $token]);
    }
}