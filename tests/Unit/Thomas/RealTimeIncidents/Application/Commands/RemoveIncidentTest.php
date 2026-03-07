<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\RealTimeIncidents\Application\Commands\RemoveIncident;
use Thomas\RealTimeIncidents\Domain\IncidentId;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;

final class RemoveIncidentTest extends TestCase
{
    public function testInstantiates(): void
    {
        $incidentId = new IncidentId('D85AA5FB1954428C84A2F636014C2A4A');

        $command = new RemoveIncident(
            $incidentId,
            IncidentMessageStatus::REMOVED,
        );

        $this->assertInstanceOf(RemoveIncident::class, $command);
        $this->assertEquals([
            'id'     => $incidentId,
            'status' => IncidentMessageStatus::REMOVED,
        ], $command->toArray());
    }
}
