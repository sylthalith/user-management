<?php

namespace App\Middlewares;

abstract class Middleware
{
    public function handle(): void
    {
        if (!$this->condition()) {
            $this->fail();
            exit();
        }
    }

    abstract protected function condition(): bool;

    abstract protected function fail(): void;
}