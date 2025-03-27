<?php

declare(strict_types=1);

namespace Core;

use src\Exceptions\RouterNotFoundException;
use src\Attributes\Route;


class Router
{
    private array $routes = [];
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function registerRoutesFromControllerAttributes(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $reflectionController = new \ReflectionClass($controller);
            foreach ($reflectionController->getMethods() as $method) {

                $attributes = $method->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $this->register($route->method, $route->routePath, [$controller, $method->getName()]);
                }
            }
        }
    }

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

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = $this->getRouteFromUri($requestUri);

        $action = $this->getAction($route, $requestMethod);

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

        $class = $this->container->get($class);

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