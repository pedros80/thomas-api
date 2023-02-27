<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain\Entities;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\Events\IncidentWasAdded;
use Thomas\RealTimeIncidents\Domain\Events\IncidentWasRemoved;
use Thomas\RealTimeIncidents\Domain\Events\IncidentWasUpdated;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;

final class Incident extends EventSourcedAggregateRoot
{
    private IncidentID $id;
    private IncidentMessageStatus $status;
    private Body $body;

    public static function add(
        IncidentID $id,
        IncidentMessageStatus $status,
        Body $body
    ): Incident {
        $incident = new Incident();

        $incident->apply(
            new IncidentWasAdded(
                $id,
                $status,
                $body
            )
        );

        return $incident;
    }

    public function update(
        IncidentID $id,
        IncidentMessageStatus $status,
        Body $body
    ): void {
        $this->apply(
            new IncidentWasUpdated(
                $id,
                $status,
                $body
            )
        );
    }

    public function remove(
        IncidentID $id,
        IncidentMessageStatus $status
    ): void {
        $this->apply(
            new IncidentWasRemoved(
                $id,
                $status
            )
        );
    }

    public function applyIncidentWasAdded(IncidentWasAdded $event): void
    {
        $this->id     = $event->id();
        $this->status = $event->status();
        $this->body   = $event->body();
    }

    public function applyIncidentWasUpdated(IncidentWasUpdated $event): void
    {
        $this->status = $event->status();
        $this->body   = $event->body();
    }

    public function applyIncidentWasRemoved(IncidentWasRemoved $event): void
    {
        $this->status = $event->status();
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->id;
    }
}
