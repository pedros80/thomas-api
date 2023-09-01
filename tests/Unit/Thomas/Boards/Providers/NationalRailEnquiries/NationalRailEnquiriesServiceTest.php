<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Boards\Providers\NationalRailEnquiries;

use PHPUnit\Framework\TestCase;
use Tests\Mocks\Pedros80\NREphp\Services\MockLiveDepartureBoard;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Providers\NationalRailEnquiries\NationalRailEnquiriesService;
use Thomas\Boards\Providers\NationalRailEnquiries\NREBoardMapper;
use Thomas\Shared\Domain\CRS;

final class NationalRailEnquiriesServiceTest extends TestCase
{
    private NationalRailEnquiriesService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new NationalRailEnquiriesService(new MockLiveDepartureBoard(), new NREBoardMapper(), 1);
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
