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
        return $_POST[$this->storageKey] ?? null;
    }

    private function getSessionToken(): ?string
    {
        return $_SESSION[$this->storageKey] ?? null;
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
        if (!$this->getSessionToken() || !$this->getRequestToken()) {
            return false;
        }

        return $this->getSessionToken() === $this->getRequestToken();
    }
}