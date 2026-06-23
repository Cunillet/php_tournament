<?php
declare(strict_types=1);

namespace App\Container;

class Container {
    private array $instances = [];
    private array $definitions = [];

    public function set(string $class, callable $factory): void {
        $this->definitions[$class] = $factory;
    }

    public function get(string $class): object {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        if (isset($this->definitions[$class])) {
            $instance = ($this->definitions[$class])($this);
            $this->instances[$class] = $instance;
            return $instance;
        }

        return $this->resolve($class);
    }

    public function has(string $class): bool {
        return isset($this->definitions[$class]) || class_exists($class);
    }

    private function resolve(string $class): object {
        $reflection = new \ReflectionClass($class);
        
        if (!$reflection->isInstantiable()) {
            throw new \Exception("Class {$class} is not instantiable");
        }

        $constructor = $reflection->getConstructor();
        
        if (!$constructor) {
            return new $class();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            
            if (!$type || $type->isBuiltin()) {
                throw new \Exception("Cannot resolve parameter {$parameter->getName()}");
            }

            $dependencies[] = $this->get($type->getName());
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}
