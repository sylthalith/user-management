<?php

namespace App\Validation\Rules;

use Rakit\Validation\Rule;

class UniqueRule extends DatabaseRule
{
    protected $message = ":attribute already exists";
    protected $fillable_params = ['table', 'column'];

    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);

        $table = $this->parameter('table');
        $column = $this->parameter('column');

        return !$this->recordExists($table, $column, $value);
    }
}