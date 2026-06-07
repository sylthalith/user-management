<?php

namespace App\Validation\Rules;

class UniqueRule extends DatabaseRule
{
    protected $message = ":attribute already exists";
    protected $fillable_params = ['table', 'column', 'except'];

    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);

        $table = $this->parameter('table');
        $column = $this->parameter('column');
        $except = $this->parameter('except');

        return !$this->recordExists($table, $column, $value, $except);
    }
}