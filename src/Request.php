<?php

namespace App;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class Request
{
    private static ?Validation $validation = null;
    private static ?array $messages = null;
    private static ?array $aliases = null;
    private static ?array $customRules = null;

    private static function setConfig(): void
    {
        self::$messages = require config('validation/messages');
        self::$aliases = require config('validation/aliases');
        self::$customRules = require VALIDATION . '/rules.php';
    }
    public static function validate($rules): bool
    {
        self::setConfig();

        $validator = new Validator;

        foreach (self::$customRules as $rule => $class) {
            $validator->addValidator($rule, new $class());
        }

        self::$validation = $validator->make($_POST, $rules, self::$messages);
        self::$validation->setAliases(self::$aliases);

        self::$validation->validate();

        return !self::$validation->fails();
    }

    public static function validationErrors(): array
    {
        if (!self::$validation) {
            return [];
        }

        return self::$validation->errors()->toArray();
    }

    public static function isAjax(): bool
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }
}