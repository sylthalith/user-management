<?php

namespace App\Repositories;

class Repository
{
    protected static string $table;

    public static function create(array $data): int
    {
        $table = static::$table;

        $fields = implode(', ', array_keys($data));
        $questionMarks = self::generateQuestionMarks(count($data));

        $stmt = db()->prepare("INSERT INTO $table ($fields) VALUES ($questionMarks)");
        $stmt->execute(array_values($data));

        return (int) db()->lastInsertId();
    }

    protected static function findByFields(array $fields, ?int $limit = null): ?array
    {
        $table = static::$table;

        $whereClause = self::buildWhereClause($fields);
        $limitClause = $limit ? "LIMIT $limit" : "";

        $stmt = db()->prepare("SELECT * FROM $table WHERE $whereClause $limitClause");
        $stmt->execute(array_values($fields));

        if ($limit === 1) {
            return $stmt->fetch() ?: null;
        }

        return $stmt->fetchAll() ?: null;
    }

    protected static function updateByFields(array $fields, array $data): void
    {
        $table = static::$table;

        $setClause = self::buildSetClause($data);
        $conditionClause = self::buildWhereClause($fields);

        $stmt = db()->prepare("UPDATE $table SET $setClause WHERE $conditionClause");
        $stmt->execute([...array_values($data), ...array_values($fields)]);
    }

    protected static function deleteByFields(array $fields): void
    {
        $table = static::$table;
        $conditionClause = self::buildWhereClause($fields);

        $stmt = db()->prepare("DELETE FROM $table WHERE $conditionClause");
        $stmt->execute(array_values($fields));
    }

    private static function buildPairs(array $data): array
    {
        return array_map(fn($field) => "$field = ?", array_keys($data));
    }

    private static function buildSetClause(array $data): string
    {
        $sets = self::buildPairs($data);

        return implode(', ', $sets);
    }

    private static function buildWhereClause(array $fields): string
    {
        $conditions = self::buildPairs($fields);

        return implode(' AND ', $conditions);
    }

    private static function generateQuestionMarks(int $count): string
    {
        return implode(', ', array_fill(0, $count, '?'));
    }
}