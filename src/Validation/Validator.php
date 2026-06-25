<?php

namespace App\Validation;

use App\Container;
use Rakit\Validation\Validation as RakitValidation;
use Rakit\Validation\Validator as RakitValidator;

class Validator
{
    private ?RakitValidation $validation = null;
    private ?array $messages = null;
    private ?array $aliases = null;
    private ?array $customRules = null;

    public function __construct(
        private Container $container,
    ) {}

    private function setConfig(): void
    {
        $this->messages = require config('validation/messages');
        $this->aliases = require config('validation/aliases');
        $this->customRules = require VALIDATION . '/rules.php';
    }

    private function getValidator(): RakitValidator
    {
        $validator = new RakitValidator;

        foreach ($this->customRules as $rule => $class) {
            $validator->addValidator($rule, $this->container->get($class));
        }

        return $validator;
    }

    private function getValidation(RakitValidator $validator, array $inputs, array $rules): RakitValidation
    {
        $validation = $validator->make($inputs, $rules, $this->messages);
        $validation->setAliases($this->aliases);

        return $validation;
    }

    public function validate(array $inputs, array $rules): bool
    {
        $this->setConfig();

        $validator = $this->getValidator();

        $this->validation = $this->getValidation($validator, $inputs, $rules);
        $this->validation->validate();

        return !$this->validation->fails();
    }

    public function hasErrors(): bool
    {
        return $this->validation && $this->validation->fails();
    }

    public function getErrors(): array
    {
        return $this->hasErrors() ? $this->validation->errors()->toArray() : [];
    }
}