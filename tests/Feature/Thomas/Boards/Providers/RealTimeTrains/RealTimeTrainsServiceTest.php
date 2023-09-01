<?php

namespace Tests\Feature\Thomas\Boards\Providers\RealTimeTrains;

use Tests\TestCase;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Providers\RealTimeTrains\RealTimeTrainsService;
use Thomas\Shared\Domain\CRS;

final class RealTimeTrainsServiceTest extends TestCase
{
    public function testDeparturesReturnsBoard(): void
    {
        /** @var RealTimeTrainsService $service */
        $service = app(RealTimeTrainsService::class);

        $board = $service->departures(CRS::fromString('kdy'));

        $this->assertInstanceOf(Board::class, $board);
    }

    public function testArrivalsReturnsBoard(): void
    {
        /** @var RealTimeTrainsService $service */
        $service = app(RealTimeTrainsService::class);

        $board = $service->arrivals(CRS::fromString('kdy'));

        $this->assertInstanceOf(Board::class, $board);
    }

    public function testPlatformReturnsBoard(): void
    {
        /** @var RealTimeTrainsService $service */
        $service = app(RealTimeTrainsService::class);

        $board = $service->departuresPlatform(CRS::fromString('kdy'), '1');

        $this->assertInstanceOf(Board::class, $board);
    }
}
