<?php

namespace App\Validation\Rules;

use Rakit\Validation\Rule;

class UniqueRule extends Rule
{
    protected $message = ":attribute already exists";
    protected $fillable_params = ['table', 'column'];

    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);

        $table = $this->parameter('table');
        $column = $this->parameter('column');

        $stmt = db()->prepare("SELECT * FROM $table WHERE $column = :value");
        $stmt->execute(['value' => $value]);

        $data = $stmt->fetch();

        return !$data;
    }
}