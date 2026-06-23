<?php
declare(strict_types=1);

namespace App\Router;

class RouteCollection
{
    private array $routes = [];

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function findRoute(string $method, string $uri): ?Route
    {
        $uri = parse_url($uri, PHP_URL_PATH) ?: '/';
        
        foreach ($this->routes as $route) {
            if ($route->matches($method, $uri)) {
                return $route;
            }
        }

        return null;
    }
}
