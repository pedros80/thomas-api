<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;

final class StationTest extends TestCase
{
    public function testInstantiates(): void
    {
        $station = new Station(
            new Code('DAM'),
            new Name('Dalmeny')
        );

        $this->assertInstanceOf(Station::class, $station);
        $this->assertEquals([
            'code' => 'DAM',
            'name' => 'Dalmeny',
        ], $station->toArray());
        $this->assertEquals([
            'code' => 'DAM',
            'name' => 'Dalmeny',
        ], $station->jsonSerialize());
    }
}
