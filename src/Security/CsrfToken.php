<?php

namespace App\Security;

class CsrfToken
{
    private string $key = 'csrf_token';

    private function generate(): string
    {
        return bin2hex(random_bytes(32));
    }

    private function getRequestToken(): ?string
    {
        if (isset($_POST[$this->key])) {
            return $_POST[$this->key];
        }

        if (isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
            return $_SERVER['HTTP_X_CSRF_TOKEN'];
        }

        return null;
    }

    private function getSessionToken(): ?string
    {
        return $_SESSION[$this->key] ?? null;
    }

    private function setSessionToken(string $token): void
    {
        $_SESSION[$this->key] = $token;
    }

    public function get(): string
    {
        if (!$this->getSessionToken()) {
            $this->setSessionToken($this->generate());
        }

        return $this->getSessionToken();
    }

    public function verify(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return true;
        }

        $sessionToken = $this->getSessionToken();
        $requestToken = $this->getRequestToken();

        if (!$sessionToken || !$requestToken) {
            return false;
        }

        return hash_equals($requestToken, $sessionToken);
    }
}