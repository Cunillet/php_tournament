<?php

declare(strict_types=1);

namespace App\Tests\Unit\Router;

use App\Router\Route;
use PHPUnit\Framework\TestCase;

/** @covers \App\Router\Route */
final class RouteTest extends TestCase
{
    public function testConstructorSetsProperties(): void
    {
        // Given
        $path = '/tournaments/{id}';
        $controller = 'App\Controller\TournamentController';
        $action = 'show';
        $methods = ['GET'];

        // When
        $route = new Route($path, $controller, $action, $methods);

        // Then
        $this->assertSame($path, $route->getPath());
        $this->assertSame($controller, $route->getController());
        $this->assertSame($action, $route->getAction());
        $this->assertSame(['GET'], $route->getMethods());
    }

    public function testDefaultMethodIsGet(): void
    {
        // Given / When
        $route = new Route('/test', 'C', 'a');

        // Then
        $this->assertSame(['GET'], $route->getMethods());
    }

    public function testMethodsAreStoredUppercase(): void
    {
        // Given / When
        $route = new Route('/test', 'C', 'a', ['get', 'post']);

        // Then
        $this->assertSame(['GET', 'POST'], $route->getMethods());
    }

    public function testSetAndGetMiddlewares(): void
    {
        // Given
        $route = new Route('/admin', 'C', 'a');
        $middlewares = ['App\Middleware\AuthMiddleware'];

        // When
        $returned = $route->setMiddlewares($middlewares);

        // Then
        $this->assertSame($middlewares, $route->getMiddlewares());
        $this->assertSame($route, $returned);
    }

    public function testSetAndGetParameters(): void
    {
        // Given
        $route = new Route('/users/{id}', 'C', 'a');
        $parameters = ['id' => '42'];

        // When
        $returned = $route->setParameters($parameters);

        // Then
        $this->assertSame($parameters, $route->getParameters());
        $this->assertSame($route, $returned);
    }

    /** @dataProvider provideMatchingCases */
    public function testMatchesReturnsTrueForMatchingRoute(
        string $routePath,
        string $method,
        string $uri,
        array $expectedParams
    ): void {
        // Given
        $route = new Route($routePath, 'C', 'a', [$method]);

        // When
        $result = $route->matches($method, $uri);

        // Then
        $this->assertTrue($result);
        $this->assertSame($expectedParams, $route->getParameters());
    }

    public static function provideMatchingCases(): iterable
    {
        yield 'static path' => ['/home', 'GET', '/home', []];
        yield 'single param' => ['/users/{id}', 'GET', '/users/42', ['id' => '42']];
        yield 'multiple params' => ['/tournaments/{tid}/players/{pid}', 'GET', '/tournaments/5/players/99', ['tid' => '5', 'pid' => '99']];
    }

    /** @dataProvider provideNonMatchingCases */
    public function testReturnsFalseWhenRouteDoesNotMatch(
        string $routePath,
        array $routeMethods,
        string $requestMethod,
        string $uri
    ): void {
        // Given
        $route = new Route($routePath, 'C', 'a', $routeMethods);

        // When
        $result = $route->matches($requestMethod, $uri);

        // Then
        $this->assertFalse($result);
    }

    public static function provideNonMatchingCases(): iterable
    {
        yield 'wrong method' => ['/home', ['GET'], 'POST', '/home'];
        yield 'different path' => ['/users', ['GET'], 'GET', '/posts'];
        yield 'extra segments' => ['/users', ['GET'], 'GET', '/users/1'];
    }

    public function testGetParametersReturnsEmptyArrayByDefault(): void
    {
        // Given / When
        $route = new Route('/test', 'C', 'a');

        // Then
        $this->assertSame([], $route->getParameters());
    }

    public function testGetMiddlewaresReturnsEmptyArrayByDefault(): void
    {
        // Given / When
        $route = new Route('/test', 'C', 'a');

        // Then
        $this->assertSame([], $route->getMiddlewares());
    }
}
