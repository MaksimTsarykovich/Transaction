<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouterNotFoundException;

class Router
{
    private array $routes;

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, callable|array $action)
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action)
    {
        return $this->register('post', $route, $action);
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = $this->getRouteFromUri($requestUri);

        $action = $this->getAction($route,$requestMethod);
        
        return $this->handleAction($action, $requestMethod, $route);
    }

    protected function handleAction(array $action, string $requestMethod, string $route)
    {
        if (!$action) {
            throw new RouterNotFoundException();
        }

        if (is_callable($action)) {
            return $action();
        }

        if (is_array($action)) {
            return $this->resolveControllerAction($action);
        }
        throw new RouterNotFoundException();
    }

    protected function resolveControllerAction(array $action)
    {
        [$class, $method] = $action;
        if (!class_exists($class)) {
            throw new RouterNotFoundException();
        }
        $class = new $class();
        if (!method_exists($class, $method)) {
            throw new RouterNotFoundException();
        }
        return call_user_func_array([$class, $method], $action);
    }

    protected function getRouteFromUri(string $requestUri)
    {
        return explode('?', $requestUri)[0];
    }

    private function getAction(string $route, string $requestMethod)
    {
        return $this->routes[$requestMethod][$route] ?? null;
    }
}