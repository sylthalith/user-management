<?php

namespace App\Middlewares;

abstract class Middleware
{
    public function handle() {
        if (!$this->condition()) {
            redirect($this->redirectUrl());
            exit;
        }
    }

    abstract protected function condition(): bool;

    abstract protected function redirectUrl(): string;
}