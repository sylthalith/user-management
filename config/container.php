<?php

use App\Database;

$container->singleton(PDO::class, fn() => Database::get());