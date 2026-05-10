<?php

namespace App\Middlewares;

use App\Security\CsrfToken;

class CsrfMiddleware extends Middleware
{
    private CsrfToken $csrfToken;

    public function __construct()
    {
        $this->csrfToken = new CsrfToken();
    }

    protected function condition(): bool
    {
        return $this->csrfToken->verify();
    }

    protected function fail(): void
    {
        header('HTTP/1.0 403 Forbidden');
        echo 'Forbidden';
    }
}