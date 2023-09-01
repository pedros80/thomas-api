<?php

declare(strict_types=1);

namespace Tests\Feature\Thomas\Boards\Providers\NationalRailEnquiries;

use Tests\Mocks\NationalRailEnquiries\MockService;
use Tests\TestCase;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Providers\NationalRailEnquiries\NationalRailEnquiriesService;
use Thomas\Boards\Providers\NationalRailEnquiries\NREBoardMapper;
use Thomas\Shared\Domain\CRS;

final class NationalRailEnquiriesServiceTest extends TestCase
{
    private NationalRailEnquiriesService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new NationalRailEnquiriesService(new MockService(), new NREBoardMapper(), 1);
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
