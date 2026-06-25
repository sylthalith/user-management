<?php

namespace App\Middlewares;

use App\Security\CsrfToken;

class CsrfMiddleware extends Middleware
{
    public function __construct(
        private CsrfToken $csrf,
    ) {}

    protected function condition(): bool
    {
        return $this->csrf->verify();
    }

    protected function fail(): void
    {
        abort(403, 'Доступ запрещен');
    }
}