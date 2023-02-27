<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Infrastructure;

use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\InMemoryEventStore;
use PHPUnit\Framework\TestCase;
use Thomas\RealTimeIncidents\Domain\Exceptions\IncidentNotFound;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Infrastructure\BroadwayRepository;

final class BroadwayRepositoryTest extends TestCase
{
    public function testIncidentCantBeFoundThrowsException(): void
    {
        $this->expectException(IncidentNotFound::class);
        $this->expectExceptionMessage("Incident 'D85AA5FB1954428C84A2F636014C2A4A' not found.");

        $repo = new BroadwayRepository(
            new InMemoryEventStore(),
            new SimpleEventBus()
        );

        $repo->find(new IncidentID('D85AA5FB1954428C84A2F636014C2A4A'));
    }
}
