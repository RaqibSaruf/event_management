<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\NotFoundException;

class Router
{
    protected array $routes = [];

    public function add(string $method, string $path, array $controllerOption, array $middlewares = []): void
    {
        $this->routes[strtoupper($method)][$path] = [
            'controller_option' => $controllerOption,
            'middlewares' => $middlewares
        ];
    }

    public function dispatch(Request $request, Container $container): void
    {
        $method = $request->method();
        $path = $request->uri();

        $isRoutMatched = $this->matchRoute($method, $path);

        if (!$isRoutMatched) {
            throw new NotFoundException();
        }

        [$controllerOption, $params, $middlewares] = $isRoutMatched;
        [$controller, $controllerMethod] = $controllerOption;

        $controllerInstance = $container->resolve($controller);

        $pipeline = array_reduce(
            $middlewares,
            function ($next, $middlewareClass) use ($container) {
                $middleware = $container->resolve($middlewareClass);

                return function ($request) use ($middleware, $next) {
                    return $middleware->handle($request, $next);
                };
            },
            function ($request) use ($container, $controllerInstance, $controllerMethod, $params) {
                $resolvedParams = $container->resolveMethodParameters($controllerInstance, $controllerMethod, $params);

                return $controllerInstance->$controllerMethod(...$resolvedParams);
            }
        );

        echo $pipeline($request);
    }

    private function matchRoute(string $method, string $path): ?array
    {
        if (!isset($this->routes[$method])) {
            return null;
        }
        $path = trim($path, '/');
        foreach ($this->routes[$method] as $route => $options) {
            $route = trim($route, '/');
            $routePattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
            $routePattern = '#^' . $routePattern . '$#';
            if (preg_match($routePattern, $path, $matches)) {
                array_shift($matches);
                $params = $matches;
                return [$options['controller_option'], $params, $options['middlewares'] ?? []];
            }
        }

        return null;
    }
}