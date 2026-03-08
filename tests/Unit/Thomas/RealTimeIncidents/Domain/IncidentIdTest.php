<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\RealTimeIncidents\Domain\Exceptions\InvalidIncidentId;
use Thomas\RealTimeIncidents\Domain\IncidentId;

final class IncidentIdTest extends TestCase
{
    public function testInstantiates(): void
    {
        $id = new IncidentId('D85AA5FB1954428C84A2F636014C2A4A');

        $this->assertInstanceOf(IncidentId::class, $id);
        $this->assertEquals('D85AA5FB1954428C84A2F636014C2A4A', (string) $id);
    }

    public function testInvalidIDThrowsException(): void
    {
        $this->expectException(InvalidIncidentId::class);
        $this->expectExceptionMessage("D85AA5FB19544' is not a valid Incident ID");

        new IncidentId('D85AA5FB19544');
    }
}
