<?php
declare(strict_types=1);

namespace App\Router;

class Route {
    private string $path;
    private string $controller;
    private string $action;
    private array $methods;
    private array $middlewares = [];
    private array $parameters = [];

    public function __construct(
        string $path,
        string $controller,
        string $action,
        array $methods = ['GET']
    ) {
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
        $this->methods = array_map('strtoupper', $methods);
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getController(): string {
        return $this->controller;
    }

    public function getAction(): string {
        return $this->action;
    }

    public function getMethods(): array {
        return $this->methods;
    }

    public function getMiddlewares(): array {
        return $this->middlewares;
    }

    public function setMiddlewares(array $middlewares): self {
        $this->middlewares = $middlewares;
        return $this;
    }

    public function getParameters(): array {
        return $this->parameters;
    }

    public function setParameters(array $parameters): self {
        $this->parameters = $parameters;
        return $this;
    }

    public function matches(string $method, string $uri): bool|array {
        if (!in_array(strtoupper($method), $this->methods, true)) {
            return false;
        }

        $pattern = $this->convertToRegex($this->path);
        
        if (preg_match($pattern, $uri, $matches)) {
            $parameters = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            $this->setParameters($parameters);
            return true;
        }

        return false;
    }

    private function convertToRegex(string $path): string {
        // Convert {param} to regex capturing groups
        $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
}
