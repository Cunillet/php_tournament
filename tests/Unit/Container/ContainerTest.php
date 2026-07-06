<?php

declare(strict_types=1);

namespace App\Tests\Unit\Container;

use App\Container\Container;
use PHPUnit\Framework\TestCase;

/** @covers \App\Container\Container */
final class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    public function testSetAndGetReturnsSameInstance(): void
    {
        // Given
        $this->container->set('stdClass', fn () => new \stdClass());

        // When
        $instance1 = $this->container->get('stdClass');
        $instance2 = $this->container->get('stdClass');

        // Then
        $this->assertInstanceOf(\stdClass::class, $instance1);
        $this->assertSame($instance1, $instance2);
    }

    public function testGetAutoResolvesClassWithoutConstructor(): void
    {
        // Given / When
        $instance = $this->container->get(\stdClass::class);

        // Then
        $this->assertInstanceOf(\stdClass::class, $instance);
    }

    public function testGetAutoResolvesClassWithTypedDependencies(): void
    {
        // Given
        $dep = new class () {
        };
        $main = new class ($dep) {
            public function __construct(public readonly object $dependency)
            {
            }
        };

        $this->container->set($dep::class, fn () => $dep);
        $this->container->set($main::class, fn () => $main);

        // When
        $mainInstance = $this->container->get($main::class);

        // Then
        $this->assertSame($main, $mainInstance);
        $this->assertSame($dep, $mainInstance->dependency);
    }

    public function testHasReturnsTrueForDefinedClass(): void
    {
        // Given
        $this->container->set(\stdClass::class, fn () => new \stdClass());

        // When / Then
        $this->assertTrue($this->container->has(\stdClass::class));
    }

    public function testHasReturnsFalseForNonExistentClass(): void
    {
        // Given / When / Then
        $this->assertFalse($this->container->has('NonExistent\\Class'));
    }

    public function testResolveThrowsExceptionForNonInstantiableClass(): void
    {
        // Then
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('not instantiable');

        // When
        $this->container->get(\Countable::class);
    }

    public function testFactoryReceivesContainerAsArgument(): void
    {
        // Given
        $receivedContainer = null;
        $this->container->set('test', function ($c) use (&$receivedContainer) {
            $receivedContainer = $c;
            return new \stdClass();
        });

        // When
        $this->container->get('test');

        // Then
        $this->assertSame($this->container, $receivedContainer);
    }
}
