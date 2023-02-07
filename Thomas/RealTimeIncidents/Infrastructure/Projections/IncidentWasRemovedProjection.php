<?php

namespace Thomas\RealTimeIncidents\Infrastructure\Projections;

use Thomas\RealTimeIncidents\Domain\Events\IncidentWasRemoved;
use Thomas\Shared\Infrastructure\Projector;

final class IncidentWasRemovedProjection extends Projector
{
    public function applyIncidentWasRemoved(IncidentWasRemoved $event): void
    {
        $this->client->deleteItem([
            'Key'    => $this->marshaler->marshalItem([
                'PK'    => (string) $event->id(),
                'EType' => 'RTI',
            ]),
            'TableName' => $this->tableName,
        ]);
    }
}
