<?php

namespace App\Middlewares;

use App\Security\Auth;

class AuthMiddleware extends Middleware
{
    public function __construct(
        private Auth $auth,
    ) {}

    protected function condition(): bool {
        return $this->auth->check();
    }

    protected function fail(): void
    {
        redirect('/login');
    }
}