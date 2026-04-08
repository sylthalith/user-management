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

        $pdo = new PDO("mysql:host={$db['host']};dbname={$db['database']};charset=utf8", $db['user'], $db['password']);

        self::$pdo = $pdo;
    }
}