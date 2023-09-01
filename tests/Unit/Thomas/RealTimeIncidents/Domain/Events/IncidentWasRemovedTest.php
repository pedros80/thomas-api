<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Domain\Events;

use PHPUnit\Framework\TestCase;
use function Safe\json_encode;
use Thomas\RealTimeIncidents\Domain\Events\IncidentWasRemoved;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;

final class IncidentWasRemovedTest extends TestCase
{
    public function testSerializes(): void
    {
        $event = new IncidentWasRemoved(
            new IncidentID('D85AA5FB1954428C84A2F636014C2A4A'),
            IncidentMessageStatus::removed()
        );

        /** @var string $json */
        $json     = json_encode($event);
        $newEvent = IncidentWasRemoved::deserialize($json);

        $this->assertInstanceOf(IncidentWasRemoved::class, $newEvent);
        $this->assertEquals(new IncidentID('D85AA5FB1954428C84A2F636014C2A4A'), $event->id());
        $this->assertEquals($event, $newEvent);
    }
}
