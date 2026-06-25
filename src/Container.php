<?php

namespace App;

use ReflectionClass;

class Container
{
    private array $bindings = [];
    private array $singletons = [];
    private array $instances = [];

    public function __construct()
    {
        $this->instances[self::class] = $this;
    }

    public function get(string $initClass): object
    {
        if (array_key_exists($initClass, $this->instances)) {
            return $this->instances[$initClass];
        }

        if (array_key_exists($initClass, $this->singletons)) {
            $instance = $this->singletons[$initClass]();

            $this->instances[$initClass] = $instance;

            return $instance;
        }

        if (array_key_exists($initClass, $this->bindings)) {
            $callable = $this->bindings[$initClass];

            return $callable();
        }

        $constructor = new ReflectionClass($initClass)->getConstructor();

        if (!$constructor) {
            return new $initClass();
        }

        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return new $initClass();
        }

        $classes = [];

        foreach ($parameters as $parameter) {
            $classes[] = $parameter->getType()->getName();
        }

        $objects = [];

        foreach ($classes as $class) {
            $objects[] = $this->get($class);
        }

        return new $initClass(...$objects);
    }

    public function bind(string $class, callable $callable): void
    {
        $this->bindings[$class] = $callable;
    }

    public function singleton(string $class, callable $callable): void
    {
        $this->singletons[$class] = $callable;
    }
}