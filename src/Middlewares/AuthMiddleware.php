<?php

namespace App\Middlewares;

use App\Security\Auth;
use PDO;

class AuthMiddleware extends Middleware
{
    protected function condition(): bool {
        return Auth::check();
    }

    protected function fail(): void
    {
        redirect('/login');
    }
}