<?php

namespace App;

class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $uri, callable|array $handler) {
        $this->routes[$method][$uri] = $handler;
    }

    public function get(string $uri, callable|array $handler) {
        $this->addRoute('GET', $uri, $handler);
    }

    public function post(string $uri, callable|array $handler) {
        $this->addRoute('POST', $uri, $handler);
    }

    public function dispatch(string $method, string $uri) {
        $uri = parse_url($uri)['path'];

        $handler = $this->routes[$method][$uri] ?? null;

        if (!$handler) {
            http_response_code(404);
            echo '404';
            die();
        }

        if (is_callable($handler)) {
            return $handler();
        }

        [$class, $method] = $handler;

        return (new $class)->$method();
    }
}