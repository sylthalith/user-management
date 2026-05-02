<?php

namespace App\Routing;

class Route
{
    private string $method;
    private string $uri;
    private $handler;
    private array $middlewares = [];

    public function __construct(string $method, string $uri, callable|array $handler, array $middlewares = []) {
        $this->method = $method;
        $this->uri = $uri;
        $this->handler = $handler;
        $this->middlewares = $middlewares;
    }

    public function isCurrent($method, $uri) {
        return $method === $this->method && $uri === $this->uri;
    }

    public function getHandler() {
        return $this->handler;
    }

    public function addMiddleware(string $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function checkMiddlewares() {
        foreach ($this->middlewares as $middlewareClass) {
            $middleware = new $middlewareClass();
            $middleware->handle();
        }
    }
}