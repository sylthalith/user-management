<?php

namespace App\Repositories;

class RememberTokenRepository extends Repository
{
    protected static string $table = 'remember_tokens';

    public static function findByToken(string $token): ?array
    {
        return parent::findByFields(['token' => $token], 1);
    }

    public static function deleteByToken(string $token): void
    {
        parent::deleteByFields(['token' => $token]);
    }
}