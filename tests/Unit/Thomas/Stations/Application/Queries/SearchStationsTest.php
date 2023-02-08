<?php

namespace Tests\Unit\Thomas\Stations\Application\Queries;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Application\Queries\SearchStations;
use Thomas\Stations\Domain\Station;
use Thomas\Stations\Infrastructure\ArrayStationService;

final class SearchStationsTest extends TestCase
{
    public function testSearchKnownCodeReturnsArray(): void
    {
        $query   = new SearchStations(new ArrayStationService());
        $result  = $query->get('DAM');
        $station = $result[0];

        $this->assertCount(1, $result);
        $this->assertInstanceOf(Station::class, $station);
        $this->assertEquals('DAM', $station->toArray()['code']);
        $this->assertEquals('Dalmeny', $station->toArray()['name']);
    }

    public function testSearchKnownSubstringReturnsArray(): void
    {
        $query  = new SearchStations(new ArrayStationService());
        $result = $query->get('west');

        $this->assertGreaterThan(1, count($result));
    }

    public function testSearchUnknownSubstringReturnsEmptyArray(): void
    {
        $query  = new SearchStations(new ArrayStationService());
        $result = $query->get('jobbyjobbyjobby');

        $this->assertEmpty($result);
    }
}
