<?php

namespace App\Repositories;

class UserRepository extends Repository
{
    protected static string $table = 'users';

    public static function findById(int $id): ?array
    {
        return parent::findByFields(['id' => $id], 1);
    }

    public static function findByEmail(string $email): ?array
    {
        return parent::findByFields(['email' => $email], 1);
    }

    public static function updateById(int $id, array $data): void
    {
        parent::updateByFields(
            ['id' => $id],
            $data
        );
    }
}