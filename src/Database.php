<?php

namespace App;

use PDO;

class Database
{
    private static $pdo = null;

    public static function get() {
        if (self::$pdo == null) {
            self::connect();
        }

        return self::$pdo;
    }

    private static function connect() {
        $db = require config('db');

        $charset = $db['charset'] ?? 'utf8mb4';
        $pdo = new PDO("mysql:host={$db['host']};dbname={$db['database']};charset=$charset", $db['user'], $db['password']);

        self::$pdo = $pdo;
    }
}