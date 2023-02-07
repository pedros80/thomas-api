<?php

namespace Thomas\RealTimeIncidents\Infrastructure;

use Broadway\Domain\AggregateRoot;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\Repository\AggregateNotFoundException;
use Thomas\RealTimeIncidents\Domain\Entities\Incident;
use Thomas\RealTimeIncidents\Domain\Exceptions\IncidentNotFound;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentsRepository;
use Thomas\Shared\Domain\EventBus;
use Thomas\Shared\Domain\EventStore;

class BroadwayRepository extends EventSourcingRepository implements IncidentsRepository
{
    public function __construct(EventStore $eventStore, EventBus $eventBus)
    {
        parent::__construct(
            $eventStore,
            $eventBus,
            Incident::class,
            new PublicConstructorAggregateFactory()
        );
    }

    public function find(IncidentID $id): Incident
    {
        try {
            /** @var Incident $incident */
            $incident = parent::load($id);

            return $incident;
        } catch (AggregateNotFoundException) {
            throw IncidentNotFound::fromId($id);
        }
    }

    public function save(AggregateRoot $aggregate): void
    {
        parent::save($aggregate);
    }
}
