<?php

namespace Tests\Unit\Thomas\RealTimeIncidents\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\RealTimeIncidents\Application\Commands\RemoveIncident;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;

final class RemoveIncidentTest extends TestCase
{
    public function testInstantiates(): void
    {
        $incidentID = new IncidentID('D85AA5FB1954428C84A2F636014C2A4A');

        $command = new RemoveIncident(
            $incidentID,
            IncidentMessageStatus::removed()
        );

        $this->assertInstanceOf(RemoveIncident::class, $command);
        $this->assertEquals([
            'id'     => (string) $incidentID,
            'status' => 'REMOVED',
        ], $command->toArray());
    }
}
