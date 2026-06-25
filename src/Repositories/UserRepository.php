<?php

namespace App\Repositories;

class UserRepository extends Repository
{
    protected string $table = 'users';

    public function countLastDays(int $days): int
    {
        $table = $this->table;

        return $this->exec("SELECT COUNT(*) FROM $table WHERE created_at >= NOW() - INTERVAL $days DAY")
                    ->fetchColumn();
    }

    public function countBlocked(): int
    {
        $table = $this->table;

        return $this->exec("SELECT COUNT(*) FROM $table WHERE is_blocked = 1")
                    ->fetchColumn();
    }

    public function getRecent(int $limit): array
    {
        $table = $this->table;

        return $this->exec("SELECT * FROM $table ORDER BY created_at DESC LIMIT $limit")
                    ->fetchAll();
    }
}