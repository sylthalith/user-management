<?php

namespace App\Routing;

use App\Security\CsrfToken;

class Route
{
    private string $method;
    private string $uri;
    private $handler;
    private array $middlewares = [];
    private array $parameters = [];

    public function __construct(string $method, string $uri, callable|array $handler, array $middlewares = []) {
        $this->method = $method;
        $this->uri = $uri;
        $this->handler = $handler;
        $this->middlewares = $middlewares;
    }

    public function isCurrent($method, $uri): bool
    {
        if ($method !== $this->method) {
            return false;
        }

        if ($uri === $this->uri) {
            return true;
        }

        if ($this->isUriRegex() && preg_match($this->uri, $uri)) {
            $parameters = $this->getParametersFromUri($uri);
            $this->parameters = $parameters;

            return true;
        }

        return false;
    }

    private function getParametersFromUri($uri): array
    {
        $uriWithoutDelimeters = substr($this->uri, 1, -1);
        $separated = explode('/', $uriWithoutDelimeters);
        $separated = array_values(array_filter($separated));

        $parametersPositions = [];

        for ($i = 0; $i < count($separated); $i++) {
            if (!ctype_alnum($separated[$i])) {
                $parametersPositions[] = $i;
            }
        }

        $separated = explode('/', $uri);
        $separated = array_values(array_filter($separated));

        $parameters = [];

        for ($i = 0; $i < count($separated); $i++) {
            if (in_array($i, $parametersPositions)) {
                $parameters[] = $separated[$i];
            }
        }

        return $parameters;
    }

    private function isUriRegex(): bool
    {
        return @preg_match($this->uri, '') !== false;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getHandler(): array|callable
    {
        return $this->handler;
    }

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function checkMiddlewares()
    {
        foreach ($this->middlewares as $middlewareClass) {
            $middleware = new $middlewareClass();
            $middleware->handle();
        }
    }
}