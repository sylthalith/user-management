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
    private static array $defaultPatterns = [
        'id'   => '[0-9]+',
        'slug' => '[a-z0-9]+(?:-[a-z0-9]+)*',
        'default' => '[a-z0-9]+',
    ];

    public function __construct(string $method, string $uri, callable|array $handler, array $middlewares = []) {
        $this->method = $method;
        $this->uri = trim($uri, '/');
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

        if ($this->isUriParameterized() && $this->match($uri)) {
            $this->parameters = $this->getParametersFromUri($uri);

            return true;
        }

        return false;
    }

    private function match($uri): bool
    {
        return preg_match($this->createPattern(), $uri);
    }

    private function isUriParameterized(): bool
    {
        return str_contains($this->uri, '{') && str_contains($this->uri, '}');
    }

    private function getParametersFromUri($uri): array
    {
        $routerParams = $this->parseParameters();
        $requestParams = [];

        preg_match($this->createPattern(), $uri, $matches);

        foreach ($routerParams as $param) {
            $requestParams[$param] = $matches[$param];
        }

        return $requestParams;
    }

    private function parseParameters(): array
    {
        $params = [];

        $splitted = explode('/', $this->uri);

        for ($i = 0; $i < count($splitted); $i++) {
            $part = $splitted[$i];
            if (preg_match('#{(?P<param>[a-z]+)}#', $part, $matches)) {
                $params[$i] = $matches['param'];
            }
        }

        return $params;
    }

    private function createPattern(): string
    {
        $splitted = explode('/', $this->uri);

        $params = $this->parseParameters();

        $pattern = [];

        for ($i = 0; $i < count($splitted); $i++) {
            if (array_key_exists($i, $params)) {
                $subPattern = "(?P<$params[$i]>" . (self::$defaultPatterns[$params[$i]] ?? self::$defaultPatterns['default']) . ")";
            } else {
                $subPattern = $splitted[$i];
            }

            $pattern[] = $subPattern;
        }

        $pattern = implode('/', $pattern);

        return '#^' . $pattern . '$#';
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