<?php

namespace App\Repositories;

use PDOStatement;

class Repository
{
    protected static string $table;

    protected static function exec(string $sql, array $params = []): PDOStatement
    {
        $stmt = db()->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    protected static function query(string $sql, array $params = []): array
    {
        return self::exec($sql, $params)->fetchAll();
    }

    protected static function queryOne(string $sql, array $params = []): ?array
    {
        return self::exec($sql, $params)->fetch() ?: null;
    }

    public static function create(array $data): int
    {
        $table = static::$table;

        $fields = implode(', ', array_keys($data));
        $questionMarks = self::generateQuestionMarks(count($data));

        $sql = "INSERT INTO $table ($fields) VALUES ($questionMarks)";
        $params = array_values($data);

        self::exec($sql, $params);

        return (int) db()->lastInsertId();
    }

    public static function findOne(array $fields): ?array
    {
        $table = static::$table;

        $whereClause = self::buildWhereClause($fields);

        $sql = "SELECT * FROM $table WHERE $whereClause";
        $params = array_values($fields);

        return self::queryOne($sql, $params);
    }

    public static function update(array $fields, array $data): void
    {
        $table = static::$table;

        $setClause = self::buildSetClause($data);
        $whereClause = self::buildWhereClause($fields);

        $sql = "UPDATE $table SET $setClause WHERE $whereClause";
        $params = [...array_values($data), ...array_values($fields)];

        self::exec($sql, $params);
    }

    public static function delete(array $fields): void
    {
        $table = static::$table;

        $whereClause = self::buildWhereClause($fields);

        $sql = "DELETE FROM $table WHERE $whereClause";
        $params = array_values($fields);

        self::exec($sql, $params);
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

    private static function buildPairs(array $data): array
    {
        return array_map(fn($field) => "$field = ?", array_keys($data));
    }

    private static function generateQuestionMarks(int $count): string
    {
        return implode(', ', array_fill(0, $count, '?'));
    }
}