<?php

namespace App\Security;

class CsrfToken
{
    private string $storageKey = 'csrf_token';

    private function generate(): string
    {
        return bin2hex(random_bytes(32));
    }

    private function getRequestToken(): ?string
    {
        if (isset($_POST[$this->storageKey])) {
            return $_POST[$this->storageKey];
        }

        if (isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
            return $_SERVER['HTTP_X_CSRF_TOKEN'];
        }

        return null;
    }

    private function getSessionToken(): ?string
    {
        if (isset($_SESSION[$this->storageKey])) {
            return $_SESSION[$this->storageKey];
        }

        return null;
    }

    private function setSessionToken(string $token): void
    {
        $_SESSION[$this->storageKey] = $token;
    }

    public function get() : string
    {
        if (!$this->getSessionToken()) {
            $this->setSessionToken($this->generate());
        }

        return $this->getSessionToken();
    }

    public function verify() : bool
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