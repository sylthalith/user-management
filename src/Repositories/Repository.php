<?php

namespace App\Repositories;

use PDO;
use PDOStatement;

abstract class Repository
{
    protected string $table;

    public function __construct(
        protected PDO $pdo
    ) {}

    protected function exec(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    protected function query(string $sql, array $params = []): array
    {
        return $this->exec($sql, $params)->fetchAll();
    }

    protected function queryOne(string $sql, array $params = []): ?array
    {
        return $this->exec($sql, $params)->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $table = $this->table;

        $fields = implode(', ', array_keys($data));
        $questionMarks = $this->generateQuestionMarks(count($data));

        $sql = "INSERT INTO $table ($fields) VALUES ($questionMarks)";
        $params = array_values($data);

        $this->exec($sql, $params);

        return (int) $this->pdo->lastInsertId();
    }

    private function select(array $fields): array
    {
        $table = $this->table;

        $whereClause = $this->buildWhereClause($fields);

        $sql = "SELECT * FROM $table WHERE $whereClause";
        $params = array_values($fields);

        return [$sql, $params];
    }

    public function find(array $fields): array
    {
        return $this->query(...$this->select($fields));
    }

    public function findOne(array $fields): ?array
    {
        return $this->queryOne(...$this->select($fields));
    }

    public function update(array $fields, array $data): void
    {
        $table = $this->table;

        $setClause = $this->buildSetClause($data);
        $whereClause = $this->buildWhereClause($fields);

        $sql = "UPDATE $table SET $setClause WHERE $whereClause";
        $params = [...array_values($data), ...array_values($fields)];

        $this->exec($sql, $params);
    }

    public function delete(array $fields): void
    {
        $table = $this->table;

        $whereClause = $this->buildWhereClause($fields);

        $sql = "DELETE FROM $table WHERE $whereClause";
        $params = array_values($fields);

        $this->exec($sql, $params);
    }

    public function count(): int
    {
        $table = $this->table;

        return (int) $this->exec("SELECT COUNT(*) FROM $table")->fetchColumn();
    }

    private function buildSetClause(array $data): string
    {
        $sets = $this->buildPairs($data);

        return implode(', ', $sets);
    }

    private function buildWhereClause(array $fields): string
    {
        $conditions = $this->buildPairs($fields);

        return implode(' AND ', $conditions);
    }

    private function buildPairs(array $data): array
    {
        return array_map(fn($field) => "$field = ?", array_keys($data));
    }

    private function generateQuestionMarks(int $count): string
    {
        return implode(', ', array_fill(0, $count, '?'));
    }
}