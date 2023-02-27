<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Infrastructure;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Station;
use Thomas\Stations\Infrastructure\ArrayStationService;

final class ArrayStationServiceTest extends TestCase
{
    public function testSearchReturnsArrayOfDomainObjects(): void
    {
        $service = new ArrayStationService();
        $results = $service->search('west');

        $this->assertNotEmpty($results);
        $this->assertInstanceOf(Station::class, $results[0]);
    }

    public function testUnknownSearchTermReturnsEmptyArray(): void
    {
        $service = new ArrayStationService();
        $results = $service->search('xxxmxmxmmx');

        $this->assertEmpty($results);
    }
}
