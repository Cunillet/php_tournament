<?php

declare(strict_types=1);

namespace App\Tests\Unit\Router;

use App\Router\Route;
use App\Router\RouteCollection;
use PHPUnit\Framework\TestCase;

/** @covers \App\Router\RouteCollection */
final class RouteCollectionTest extends TestCase
{
    private RouteCollection $collection;

    protected function setUp(): void
    {
        $this->collection = new RouteCollection();
    }

    public function testAddRouteAndGetRoutes(): void
    {
        // Given
        $route = new Route('/home', 'C', 'index');

        // When
        $this->collection->addRoute($route);

        // Then
        $this->assertCount(1, $this->collection->getRoutes());
        $this->assertSame($route, $this->collection->getRoutes()[0]);
    }

    public function testGetRoutesReturnsEmptyArrayWhenNoRoutesAdded(): void
    {
        // Given / When / Then
        $this->assertSame([], $this->collection->getRoutes());
    }

    public function testFindRouteReturnsMatchingRoute(): void
    {
        // Given
        $route = new Route('/users/{id}', 'C', 'show', ['GET']);
        $this->collection->addRoute($route);

        // When
        $found = $this->collection->findRoute('GET', '/users/42');

        // Then
        $this->assertSame($route, $found);
    }

    public function testFindRouteReturnsNullWhenNoMatch(): void
    {
        // Given
        $this->collection->addRoute(new Route('/home', 'C', 'index'));

        // When
        $result = $this->collection->findRoute('GET', '/not-found');

        // Then
        $this->assertNull($result);
    }

    public function testFindStripsQueryStringFromUri(): void
    {
        // Given
        $route = new Route('/search', 'C', 'search', ['GET']);
        $this->collection->addRoute($route);

        // When
        $found = $this->collection->findRoute('GET', '/search?q=php');

        // Then
        $this->assertSame($route, $found);
    }
}
