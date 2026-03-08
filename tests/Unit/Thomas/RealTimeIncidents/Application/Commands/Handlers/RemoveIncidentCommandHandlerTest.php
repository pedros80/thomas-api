<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Tests\Unit\Thomas\RealTimeIncidents\Application\Commands\Handlers\BaseIncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\Handlers\RemoveIncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\RemoveIncident;
use Thomas\RealTimeIncidents\Domain\Events\IncidentWasRemoved;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\RealTimeIncidents\Infrastructure\BroadwayRepository;

final class RemoveIncidentCommandHandlerTest extends BaseIncidentCommandHandler
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new RemoveIncidentCommandHandler(new BroadwayRepository($eventStore, $eventBus));
    }

    public function testExistingIncidentCanBeRemoved(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->incidentId)
            ->given([
                $this->makeIncidentWasAdded(),
            ])->when(
                $this->makeRemoveIncident()
            )->then([
                $this->makeIncidentWasRemoved(),
            ]);
    }

    public function testHandleRemovingUnfoundIncidentDoesNothing(): void
    {
        $this->scenario
            ->given([])
            ->when($this->makeRemoveIncident())
            ->then([]);
    }

    private function makeRemoveIncident(): RemoveIncident
    {
        return new RemoveIncident(
            $this->incidentId,
            IncidentMessageStatus::REMOVED,
        );
    }

    private function makeIncidentWasRemoved(): IncidentWasRemoved
    {
        return new IncidentWasRemoved(
            $this->incidentId,
            IncidentMessageStatus::REMOVED,
        );
    }
}
