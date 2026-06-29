<?php

namespace App;

use PDO;

class Database
{
    public static function get(): PDO
    {
        $db = require config('db');

        $charset = $db['charset'] ?? 'utf8mb4';

        $pdo = new PDO("mysql:host={$db['host']};dbname={$db['database']};charset=$charset", $db['user'], $db['password']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $pdo;
    }
}