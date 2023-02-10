<?php

namespace Thomas\RealTimeIncidents\Infrastructure\Projections;

use Thomas\RealTimeIncidents\Domain\Events\IncidentWasRemoved;
use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;

final class IncidentWasRemovedProjection extends InteractsWithDynamoDb
{
    public function applyIncidentWasRemoved(IncidentWasRemoved $event): void
    {
        $this->db->deleteItem([
            'Key'    => $this->marshaler->marshalItem([
                'PK'  => (string) $event->id(),
                'SKe' => 'RTI',
            ]),
            'TableName' => $this->tableName,
        ]);
    }
}
