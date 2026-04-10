<?php

namespace App;

class Validator
{
    private array $data;
    private array $rules;
    private array $errors;
    private string $passwordConfirmationField = 'password_confirmation';

    public function __construct(array $data, array $rules) {
        $this->data = $data;
        $this->rules = $rules;
    }

    public function validate() {
        foreach ($this->rules as $field => $rules) {
            foreach ($rules as $rule) {
                if ($rule == 'required') {
                    if (!$this->require($field)) {
                        break;
                    }
                }

                if ($rule == 'email') {
                    $this->validateEmail($field);
                    continue;
                }

                if ($rule == 'phone') {
                    $this->validatePhone($field);
                    continue;
                }

                if ($rule == 'confirmed') {
                    $this->confirmPassword($field);
                    continue;
                }

                if (str_contains($rule, ':')) {
                    [$rule, $param] = explode(':', $rule);
                    if (is_numeric($param)) {
                        $param = (int) $param;

                        if ($rule == 'min') {
                            $this->min($field, $param);
                        }

                        if ($rule == 'max') {
                            $this->max($field, $param);
                        }
                    }
                }
            }
        }
    }

    public function confirmPassword($field) {
        $password = $this->data[$field];
        $passwordConfirmation = $this->data[$this->passwordConfirmationField];

        if (!$passwordConfirmation) {
            $this->addError($field, 'Не найдено поле подтверждения пароля');
            return;
        }

        if ($password !== $passwordConfirmation) {
            $this->addError($field, 'Пароли не совпадают');
        }
    }

    private function require($field) {
        if (!trim($this->data[$field])) {
            $this->addError($field, "Поле $field отсутствует");
            return false;
        }

        return true;
    }

    private function validateEmail($field) {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "Поле $field должно быть валидной почтой");
        }
    }

    private function validatePhone($field) {
        $onlyNumbers = preg_replace('/[^0-9]/', '', $this->data[$field]);

        if (strlen($onlyNumbers) != 11) {
            $this->addError($field, "Поле $field должно быть валидным номером телефона");
        }
    }

    private function min($field, $length) {
        if (strlen($this->data[$field]) < $length) {
            $this->addError($field, "Поле $field должно быть не менее $length символов");
        }
    }

    private function max($field, $length) {
        if (strlen($this->data[$field]) > $length) {
            $this->addError($field, "Поле $field должно быть менее $length символов");
        }
    }

    public function getErrors() {
        if (isset($this->errors)) {
            return $this->errors;
        }
        return [];
    }

    public function addError($field, $message) {
        $this->errors[$field][] = $message;
    }
}