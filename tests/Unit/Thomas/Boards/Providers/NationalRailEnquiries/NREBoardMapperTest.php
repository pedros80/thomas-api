<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Boards\Providers\NationalRailEnquiries;

use Pedros80\NREphp\Contracts\Boards;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\NationalRailEnquiries\MockService;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Providers\NationalRailEnquiries\NREBoardMapper;

final class NREBoardMapperTest extends TestCase
{
    private NREBoardMapper $mapper;
    private Boards $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = new NREBoardMapper();
        $this->service = new MockService();
    }

    public function testToDepartureBoard(): void
    {
        $departures = $this->mapper->toDepartureBoard($this->service->getDepBoardWithDetails(10, 'DAM'));

        $this->assertInstanceOf(Board::class, $departures);
    }

    public function testParsesNoCallingPoints(): void
    {
        $departures = $this->mapper->toDepartureBoard($this->service->getDepBoardWithDetails(10, 'GTW'));

        $this->assertInstanceOf(Board::class, $departures);
    }

    public function testParsesOneCallingPoint(): void
    {
        $departures = $this->mapper->toDepartureBoard($this->service->getDepBoardWithDetails(10, 'EDB'));

        $this->assertInstanceOf(Board::class, $departures);
    }

    public function testToArrivalsBoard(): void
    {
        $arrivals = $this->mapper->toArrivalBoard($this->service->getArrBoardWithDetails(10, 'DAM'));

        $this->assertInstanceOf(Board::class, $arrivals);
    }

    public function testToPlatformBoard(): void
    {
        $platform = $this->mapper->toPlatformBoard($this->service->getDepBoardWithDetails(10, 'DAM'));

        $this->assertInstanceOf(Board::class, $platform);
    }
}
