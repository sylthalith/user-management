<?php

namespace App\Validation\Rules;

use Rakit\Validation\Rule;

abstract class DatabaseRule extends Rule
{
    protected function recordExists($table, $column, $value): bool
    {
        $stmt = db()->prepare("SELECT 1 FROM $table WHERE $column = :value LIMIT 1");
        $stmt->execute(['value' => $value]);

        return (bool) $stmt->fetch();
    }
}