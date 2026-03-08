<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain\Entities;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\Events\IncidentWasAdded;
use Thomas\RealTimeIncidents\Domain\Events\IncidentWasRemoved;
use Thomas\RealTimeIncidents\Domain\Events\IncidentWasUpdated;
use Thomas\RealTimeIncidents\Domain\IncidentId;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;

final class Incident extends EventSourcedAggregateRoot
{
    private IncidentId $id;
    private IncidentMessageStatus $status;
    private Body $body;

    public static function add(IncidentId $id, IncidentMessageStatus $status, Body $body): Incident
    {
        $incident = new Incident();

        $incidentWasAdded = new IncidentWasAdded(
            $id,
            $status,
            $body,
        );

        $incident->apply($incidentWasAdded);

        return $incident;
    }

    public function update(IncidentId $id, IncidentMessageStatus $status, Body $body): void
    {
        $incidentWasUpdated = new IncidentWasUpdated(
            $id,
            $status,
            $body,
        );

        $this->apply($incidentWasUpdated);
    }

    public function remove(IncidentId $id, IncidentMessageStatus $status): void
    {
        $incidentWasRemoved = new IncidentWasRemoved(
            $id,
            $status,
        );

        $this->apply($incidentWasRemoved);
    }

    public function applyIncidentWasAdded(IncidentWasAdded $event): void
    {
        $this->id     = $event->id;
        $this->status = $event->status;
        $this->body   = $event->body;
    }

    public function applyIncidentWasUpdated(IncidentWasUpdated $event): void
    {
        $this->status = $event->status;
        $this->body   = $event->body;
    }

    public function applyIncidentWasRemoved(IncidentWasRemoved $event): void
    {
        $this->status = $event->status;
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->id;
    }
}
