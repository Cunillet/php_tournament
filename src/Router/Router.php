<?php
declare(strict_types=1);

namespace App\Router;

class Router
{
    private RouteCollection $routeCollection;

    public function __construct()
    {
        $this->routeCollection = new RouteCollection();
    }

    public function get(string $path, string $controller, string $action): Route
    {
        return $this->addRoute($path, $controller, $action, ['GET']);
    }

    public function post(string $path, string $controller, string $action): Route
    {
        return $this->addRoute($path, $controller, $action, ['POST']);
    }

    public function put(string $path, string $controller, string $action): Route
    {
        return $this->addRoute($path, $controller, $action, ['PUT']);
    }

    public function delete(string $path, string $controller, string $action): Route
    {
        return $this->addRoute($path, $controller, $action, ['DELETE']);
    }

    public function patch(string $path, string $controller, string $action): Route
    {
        return $this->addRoute($path, $controller, $action, ['PATCH']);
    }

    private function addRoute(string $path, string $controller, string $action, array $methods): Route
    {
        $route = new Route($path, $controller, $action, $methods);
        $this->routeCollection->addRoute($route);
        return $route;
    }

    public function getRouteCollection(): RouteCollection
    {
        return $this->routeCollection;
    }
}
