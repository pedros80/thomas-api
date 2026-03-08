<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Tests\Unit\Thomas\RealTimeIncidents\Application\Commands\Handlers\BaseIncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\AddIncident;
use Thomas\RealTimeIncidents\Application\Commands\Handlers\AddIncidentCommandHandler;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\RealTimeIncidents\Infrastructure\BroadwayRepository;

final class AddIncidentCommandHandlerTest extends BaseIncidentCommandHandler
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new AddIncidentCommandHandler(new BroadwayRepository($eventStore, $eventBus));
    }

    public function testIncidentCanBeAdded(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->incidentId)
            ->given([])
            ->when($this->makAddIncident())
            ->then([
                $this->makeIncidentWasAdded(),
            ]);
    }

    private function makAddIncident(): AddIncident
    {
        return new AddIncident(
            $this->incidentId,
            IncidentMessageStatus::NEW,
            $this->body,
        );
    }
}
