<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\GameTypeService;
use PHPUnit\Framework\TestCase;

/** @covers \App\Service\GameTypeService */
final class GameTypeServiceTest extends TestCase
{
    private GameTypeService $service;

    protected function setUp(): void
    {
        $this->service = new GameTypeService();
    }

    public function testStoreGameTypeReturnsErrorWhenNameIsMissing(): void
    {
        // Given
        $data = ['name' => '', 'version' => '1.0'];

        // When
        $result = $this->service->storeGameType($data);

        // Then
        $this->assertArrayHasKey('error', $result);
        $this->assertSame(400, $result['code']);
    }

    public function testStoreGameTypeReturnsErrorWhenVersionIsMissing(): void
    {
        // Given
        $data = ['name' => 'Chess', 'version' => ''];

        // When
        $result = $this->service->storeGameType($data);

        // Then
        $this->assertArrayHasKey('error', $result);
        $this->assertSame(400, $result['code']);
    }

    public function testStoreGameTypeReturnsErrorWhenDataIsEmpty(): void
    {
        // Given
        $data = [];

        // When
        $result = $this->service->storeGameType($data);

        // Then
        $this->assertArrayHasKey('error', $result);
        $this->assertSame(400, $result['code']);
    }
}
