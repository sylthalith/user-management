<?php

namespace App\Repositories;

class UserRepository
{
    public static function create(string $name, string $phone, string $email, string $password): int
    {
        $stmt = db()->prepare(
            'INSERT INTO users (name, phone, email, password) VALUES (:name, :phone, :email, :password)'
        );

        $stmt->execute([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'password' => $password
        ]);

        return (int) db()->lastInsertId();
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt = db()->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);

        return $stmt->fetch() ?: null;
    }
}