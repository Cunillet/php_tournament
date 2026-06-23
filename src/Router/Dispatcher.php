<?php
declare(strict_types=1);

namespace App\Router;

use App\Middleware\MiddlewareInterface;
use App\Container\Container;

class Dispatcher {
    private RouteCollection $routeCollection;
    private Container $container;
    private array $middlewares = [];

    public function __construct(
        RouteCollection $routeCollection,
        Container $container
    ) {
        $this->routeCollection = $routeCollection;
        $this->container = $container;
    }

    public function addMiddleware(MiddlewareInterface $middleware): self {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function dispatch(string $method, string $uri): mixed {
        $route = $this->routeCollection->findRoute($method, $uri);

        if (!$route) {
            throw new \Exception('Route not found', 404);
        }

        // Execute global middlewares
        $this->executeMiddlewares($route);

        // Get controller and action
        $controllerClass = $route->getController();
        $action = $route->getAction();
        $parameters = $route->getParameters();

        // Check if controller exists
        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller {$controllerClass} not found", 500);
        }

        // Create controller instance using container
        $controller = $this->container->get($controllerClass);

        // Check if action exists
        if (!method_exists($controller, $action)) {
            throw new \Exception("Action {$action} not found in {$controllerClass}", 500);
        }

        // Execute controller action with parameters
        return $this->executeControllerAction($controller, $action, $parameters);
    }

    private function executeMiddlewares(Route $route): void {
        // Execute global middlewares
        foreach ($this->middlewares as $middleware) {
            $middleware->handle($route);
        }

        // Execute route-specific middlewares
        foreach ($route->getMiddlewares() as $middlewareClass) {
            $middleware = $this->container->get($middlewareClass);
            if (!$middleware instanceof MiddlewareInterface) {
                throw new \Exception("Middleware {$middlewareClass} must implement MiddlewareInterface");
            }
            $middleware->handle($route);
        }
    }

    private function executeControllerAction(object $controller, string $action, array $parameters): mixed {
        // Use reflection to resolve dependencies
        $reflection = new \ReflectionMethod($controller, $action);
        $args = [];

        foreach ($reflection->getParameters() as $parameter) {
            $paramName = $parameter->getName();
            
            // Check if parameter exists in route parameters
            if (isset($parameters[$paramName])) {
                $args[] = $parameters[$paramName];
                continue;
            }

            // Try to resolve from container
            if ($parameter->getType() && !$parameter->getType()->isBuiltin()) {
                $type = $parameter->getType()->getName();
                if ($this->container->has($type)) {
                    $args[] = $this->container->get($type);
                    continue;
                }
            }

            // Check for default value
            if ($parameter->isDefaultValueAvailable()) {
                $args[] = $parameter->getDefaultValue();
                continue;
            }

            throw new \Exception("Cannot resolve parameter {$paramName}");
        }

        return $reflection->invokeArgs($controller, $args);
    }
}
