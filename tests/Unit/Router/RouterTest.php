<?php

declare(strict_types=1);

namespace App\Tests\Unit\Router;

use App\Router\Route;
use App\Router\Router;
use PHPUnit\Framework\TestCase;

/** @covers \App\Router\Router */
final class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetRouteIsRegistered(): void
    {
        // Given / When
        $route = $this->router->get('/home', 'C', 'index');

        // Then
        $this->assertInstanceOf(Route::class, $route);
        $this->assertSame('/home', $route->getPath());
        $this->assertSame(['GET'], $route->getMethods());
        $this->assertCount(1, $this->router->getRouteCollection()->getRoutes());
    }

    public function testPostRouteIsRegistered(): void
    {
        // Given / When
        $route = $this->router->post('/users', 'C', 'store');

        // Then
        $this->assertSame(['POST'], $route->getMethods());
    }

    public function testPutRouteIsRegistered(): void
    {
        // Given / When
        $route = $this->router->put('/users/{id}', 'C', 'update');

        // Then
        $this->assertSame(['PUT'], $route->getMethods());
    }

    public function testDeleteRouteIsRegistered(): void
    {
        // Given / When
        $route = $this->router->delete('/users/{id}', 'C', 'destroy');

        // Then
        $this->assertSame(['DELETE'], $route->getMethods());
    }

    public function testPatchRouteIsRegistered(): void
    {
        // Given / When
        $route = $this->router->patch('/users/{id}', 'C', 'patch');

        // Then
        $this->assertSame(['PATCH'], $route->getMethods());
    }

    public function testMultipleRoutesAreRegistered(): void
    {
        // Given / When
        $this->router->get('/', 'C1', 'index');
        $this->router->post('/login', 'C2', 'login');
        $this->router->get('/users/{id}', 'C3', 'show');

        // Then
        $this->assertCount(3, $this->router->getRouteCollection()->getRoutes());
    }
}
