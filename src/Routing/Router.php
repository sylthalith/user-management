<?php

namespace App\Routing;

use App\Container;

class Router
{
    private array $routes = [];
    private ?Route $lastRoute = null;

    public function __construct(
        private Container $container,
    ) {}

    private function addRoute(string $method, string $uri, callable|array $handler): Router
    {
        $route = new Route($method, $uri, $handler);
        $this->routes[] = $route;
        $this->lastRoute = $route;

        return $this;
    }

    private function getRoute($method, $uri): ?Route
    {
        foreach ($this->routes as $route) {
            if ($route->isCurrent($method, $uri)) {
                return $route;
            }
        }

        return null;
    }

    public function get(string $uri, callable|array $handler): Router
    {
        return $this->addRoute('GET', $uri, $handler);
    }

    public function post(string $uri, callable|array $handler): Router
    {
        return $this->addRoute('POST', $uri, $handler);
    }

    public function put(string $uri, callable|array $handler): Router
    {
        return $this->addRoute('PUT', $uri, $handler);
    }

    public function patch(string $uri, callable|array $handler): Router
    {
        return $this->addRoute('PATCH', $uri, $handler);
    }

    public function delete(string $uri, callable|array $handler): Router
    {
        return $this->addRoute('DELETE', $uri, $handler);
    }

    public function dispatch(string $method, string $uri)
    {
        $uri = trim(parse_url($uri)['path'], '/');

        $route = $this->getRoute($method, $uri);

        if (!$route) {
            abort(404, 'Страница не найдена');
        }

        $middlewares = $route->getMiddlewares();
        $this->checkMiddlewares($middlewares);

        $handler = $route->getHandler();
        $parameters = $route->getParameters();

        if (is_callable($handler)) {
            return $handler(...$parameters);
        }

        [$class, $method] = $handler;

        $object = $this->container->get($class);

        return $object->$method(...$parameters);
    }

    public function middleware(array|string $middlewares) {
        if (!$this->lastRoute) {
            return;
        }

        foreach (wrapArray($middlewares) as $middleware) {
            $this->lastRoute->addMiddleware($middleware);
        }
    }

    private function checkMiddlewares(array $middlewares): void
    {
        foreach ($middlewares as $middleware) {
            $this->container->get($middleware)->handle();
        }
    }
}