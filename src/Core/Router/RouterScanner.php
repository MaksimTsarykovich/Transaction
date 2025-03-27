<?php

namespace Core\Router;

use src\Attributes\Route;
use ReflectionClass;
use ReflectionMethod;

class RouterScanner
{
    private array $routes = [];

    public function scanControllers(array $controllerClasses): array
    {
        foreach ($controllerClasses as $controllerClass) {
            $this->scanController($controllerClass);
        }
        return $this->routes;
    }

    private function scanController(string $controllerClass): void
    {
        $reflectionClass = new ReflectionClass($controllerClass);

        foreach ($reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $attributes = $method->getAttributes(Route::class);

            foreach ($attributes as $attribute) {
                $route = $attribute->newInstance();

                $this->routes[] = [
                    'method' => $route->method,
                    'path' => $route->path,
                    'name' => $route->name,
                    'handler' => [$controllerClass, $method->getName()],
                    'middleware' => $route->middleware,
                ];
            }

        }
    }
}