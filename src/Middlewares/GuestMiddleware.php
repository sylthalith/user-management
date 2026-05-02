<?php

namespace App\Middlewares;

class GuestMiddleware extends Middleware
{
    protected function condition(): bool {
        return !isset($_SESSION['user_id']);
    }

    protected function redirectUrl(): string {
        return '/dashboard';
    }
}