<?php

namespace Core\Router;

use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

class Router
{
    private Dispatcher $dispatcher;

    public function __construct(array $routes)
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $collector) use ($routes) {
            foreach ($routes as $route) {
                $collector->addRoute($route['method'], $route['path'], $route['handler']);
            }
        });
    }

    public function dispatch(string $method, string $uri)
    {
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $this->dispatcher->dispatch($method, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:

        }

    }

}