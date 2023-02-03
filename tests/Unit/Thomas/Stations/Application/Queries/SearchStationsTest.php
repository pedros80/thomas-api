<?php

namespace Tests\Unit\Thomas\Stations\Application\Queries;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Application\Queries\SearchStations;
use Thomas\Stations\Infrastructure\ArrayStationService;

final class SearchStationsTest extends TestCase
{
    public function testSearchKnownCodeReturnsArray(): void
    {
        $query  = new SearchStations(new ArrayStationService());
        $result = $query->get('DAM');

        $this->assertCount(1, $result);
        $this->assertEquals('DAM', $result[0]['code']);
        $this->assertEquals('Dalmeny', $result[0]['name']);
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

        $this->assertCount(0, $result);
    }
}
