<?php

namespace Tests\Unit\Thomas\RealTimeIncidents\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\RealTimeIncidents\Domain\Exceptions\InvalidIncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentID;

final class IncidentIDTest extends TestCase
{
    public function testInstantiates(): void
    {
        $id = new IncidentID('D85AA5FB1954428C84A2F636014C2A4A');

        $this->assertInstanceOf(IncidentID::class, $id);
        $this->assertEquals('D85AA5FB1954428C84A2F636014C2A4A', (string) $id);
    }

    public function testInvalidIDThrowsException(): void
    {
        $this->expectException(InvalidIncidentID::class);
        $this->expectExceptionMessage("D85AA5FB19544' is not a valid Incident ID");

        new IncidentID('D85AA5FB19544');
    }
}
