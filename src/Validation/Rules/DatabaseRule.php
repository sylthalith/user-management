<?php

namespace App\Validation\Rules;

use Rakit\Validation\Rule;

abstract class DatabaseRule extends Rule
{
    protected function recordExists(string $table, string $column, string $value, ?string $except = null): bool
    {
        $sql = "SELECT 1 FROM $table WHERE $column = ?";
        $params = [$value];

        if ($except !== null) {
            $sql .= " AND $column != ?";
            $params[] = $except;
        }

        $sql .= " LIMIT 1";

        $stmt = db()->prepare($sql);
        $stmt->execute($params);

        return (bool) $stmt->fetch();
    }
}