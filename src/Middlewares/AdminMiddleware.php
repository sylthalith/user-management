<?php

namespace App\Middlewares;

use App\Security\Auth;

class AdminMiddleware extends Middleware
{
    public function __construct(
        private Auth $auth,
    ) {}

    protected function condition(): bool
    {
        return $this->auth->isAdmin();
    }

    protected function fail(): void
    {
        $this->auth->check() ? redirect('/profile') : redirect('/login');
    }
}