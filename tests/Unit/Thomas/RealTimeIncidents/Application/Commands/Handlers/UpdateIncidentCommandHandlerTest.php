<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Tests\Unit\Thomas\RealTimeIncidents\Application\Commands\Handlers\BaseIncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\Handlers\UpdateIncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\UpdateIncident;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\RealTimeIncidents\Infrastructure\BroadwayRepository;

final class UpdateIncidentCommandHandlerTest extends BaseIncidentCommandHandler
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new UpdateIncidentCommandHandler(new BroadwayRepository($eventStore, $eventBus));
    }

    public function testExistingIncidentCanBeUpdated(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->incidentId)
            ->given([
                $this->makeIncidentWasAdded(),
            ])->when(
                $this->makeUpdateIncident()
            )->then([
                $this->makeIncidentWasUpdated(),
            ]);
    }

    public function testOutOfSyncModifyCreatesIncidentFirst(): void
    {
        $this->scenario
            ->given([])
            ->when(
                $this->makeUpdateIncident()
            )->then([
                $this->makeIncidentWasAdded(),
                $this->makeIncidentWasUpdated(),
            ]);
    }

    private function makeUpdateIncident(): UpdateIncident
    {
        return new UpdateIncident(
            $this->incidentId,
            IncidentMessageStatus::MODIFIED,
            $this->body,
        );
    }
}
