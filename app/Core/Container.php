<?php

declare(strict_types=1);

namespace App\Core;

class Container
{
    protected array $bindings = [];

    public function bind(string $key, callable $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    public function has(string $key): bool
    {
        return isset($this->bindings[$key]);
    }

    public function make(string $key)
    {
        if (!isset($this->bindings[$key])) {
            throw new \Exception("No binding found for {$key}");
        }

        return call_user_func($this->bindings[$key]);
    }

    public function resolve(string $class)
    {
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $class;
        }

        $params = $constructor->getParameters();
        $dependencies = [];

        foreach ($params as $param) {
            $type = $param->getType();
            $typeName = $type?->getName();
            if ($type && !$type->isBuiltin()) {
                if ($this->has($typeName)) {
                    $dependencies[] = $this->make($typeName);
                } elseif (class_exists($typeName)) {
                    $dependencies[] = $this->resolve($typeName);
                }
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }

    public function resolveMethodParameters(object|string $object, string $method, array $params = []): array
    {
        $reflectionMethod = new \ReflectionMethod($object, $method);
        $parameters = $reflectionMethod->getParameters();

        $resolvedParams = [];
        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            $typeName = $type?->getName();

            if ($type && !$type->isBuiltin()) {
                if ($this->has($typeName)) {
                    $resolvedParams[] = $this->make($typeName);
                } elseif (class_exists($typeName)) {
                    $resolvedParams[] = $this->resolve($typeName);
                }
            } else {
                $resolvedParams[] = $this->castParamValue(array_shift($params), $typeName);
            }
        }

        return $resolvedParams;
    }

    private function castParamValue(mixed $value, string $type)
    {
        switch ($type) {
            case 'int':
                return (int)$value;
            case 'float':
                return (float)$value;
            case 'bool':
                return (bool)$value;
            case 'string':
                return (string)$value;
            default:
                return $value;
        }
    }
}
