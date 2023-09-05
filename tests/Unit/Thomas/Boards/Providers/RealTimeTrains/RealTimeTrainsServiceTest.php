<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Boards\Providers\RealTimeTrains;

use PHPUnit\Framework\TestCase;
use Tests\Mocks\Pedros80\RTTphp\Services\MockLocationService;
use Tests\Mocks\Pedros80\RTTphp\Services\MockServiceInformationService;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Providers\RealTimeTrains\RealTimeTrainsService;
use Thomas\Boards\Providers\RealTimeTrains\RTTBoardMapper;
use Thomas\Shared\Domain\CRS;

final class RealTimeTrainsServiceTest extends TestCase
{
    private RealTimeTrainsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RealTimeTrainsService(
            new MockLocationService(),
            new MockServiceInformationService(),
            new RTTBoardMapper(),
            5
        );
    }

    public function testDeparturesReturnsBoard(): void
    {
        $this->assertInstanceOf(Board::class, $this->service->departures(CRS::fromString('DAM')));
    }

    public function testArrivalsReturnsBoard(): void
    {
        $this->assertInstanceOf(Board::class, $this->service->arrivals(CRS::fromString('DAM')));
    }

    public function testPlatformReturnsBoard(): void
    {
        $this->assertInstanceOf(Board::class, $this->service->departuresPlatform(CRS::fromString('DAM'), '1'));
    }
}
