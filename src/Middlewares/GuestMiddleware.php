<?php

namespace App\Middlewares;

use App\Security\Auth;

class GuestMiddleware extends Middleware
{
    protected function condition(): bool {
        return !Auth::check();
    }

    protected function fail(): void
    {
        redirect('/dashboard');
    }
}