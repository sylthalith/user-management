<?php

namespace App\Validation\Rules;

use Rakit\Validation\Rule;

class PhoneRule extends Rule
{
    protected $message = ":attribute has an invalid format";

    public function check($value): bool
    {
        $onlyNumbers = preg_replace('/[^0-9]/', '', $value);

        return strlen($onlyNumbers) == 11;
    }
}