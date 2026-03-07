<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Infrastructure;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Stations;
use Thomas\Stations\Infrastructure\ArrayStationService;

final class ArrayStationServiceTest extends TestCase
{
    public function testSearchReturnStationsObject(): void
    {
        $service  = new ArrayStationService();
        $stations = $service->search('west');

        $this->assertInstanceOf(Stations::class, $stations);
        $this->assertNotEmpty($stations);
    }

    public function testUnknownSearchTermReturnsEmptyArray(): void
    {
        $service = new ArrayStationService();
        $results = $service->search('xxxmxmxmmx');

        $this->assertEmpty($results);
    }
}
