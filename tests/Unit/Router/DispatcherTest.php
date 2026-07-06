<?php

declare(strict_types=1);

namespace App\Tests\Unit\Router;

use App\Router\Dispatcher;
use App\Router\Route;
use App\Router\RouteCollection;
use PHPUnit\Framework\TestCase;

/** @covers \App\Router\Dispatcher */
final class DispatcherTest extends TestCase
{
    public function testDispatchReturnsResponseWhenRouteFound(): void
    {
        // Given
        $collection = new RouteCollection();
        $controller = new class () {
            public function show(): string
            {
                return 'hello';
            }
        };
        $route = new Route('/hello', $controller::class, 'show', ['GET']);
        $route->setParameters([]);
        $collection->addRoute($route);

        $container = new \App\Container\Container();
        $container->set($controller::class, fn () => $controller);

        $dispatcher = new Dispatcher($collection, $container);

        // When
        $result = $dispatcher->dispatch('GET', '/hello');

        // Then
        $this->assertSame('hello', $result);
    }

    public function testDispatchThrowsExceptionWhenRouteNotFound(): void
    {
        // Given
        $collection = new RouteCollection();
        $container = new \App\Container\Container();
        $dispatcher = new Dispatcher($collection, $container);

        // Then
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Route not found');
        $this->expectExceptionCode(404);

        // When
        $dispatcher->dispatch('GET', '/missing');
    }

    public function testDispatchPassesRouteParametersToAction(): void
    {
        // Given
        $collection = new RouteCollection();
        $controller = new class () {
            public function show(int $id): string
            {
                return "user-{$id}";
            }
        };
        $route = new Route('/users/{id}', $controller::class, 'show', ['GET']);
        $route->setParameters(['id' => '42']);
        $collection->addRoute($route);

        $container = new \App\Container\Container();
        $container->set($controller::class, fn () => $controller);

        $dispatcher = new Dispatcher($collection, $container);

        // When
        $result = $dispatcher->dispatch('GET', '/users/42');

        // Then
        $this->assertSame('user-42', $result);
    }
}
