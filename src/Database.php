<?php

namespace App;

use PDO;

class Database
{
    public static function get(): PDO
    {
        $db = require config('db');

        $charset = $db['charset'] ?? 'utf8mb4';

        return new PDO("mysql:host={$db['host']};dbname={$db['database']};charset=$charset", $db['user'], $db['password']);
    }
}