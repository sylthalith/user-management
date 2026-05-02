<?php

namespace App\Middlewares;

class AuthMiddleware extends Middleware
{
    protected function condition(): bool {
        return isset($_SESSION['user_id']);
    }

    protected function redirectUrl(): string {
        return '/login';
    }
}