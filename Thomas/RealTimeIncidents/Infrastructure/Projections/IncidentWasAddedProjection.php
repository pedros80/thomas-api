<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Infrastructure\Projections;

use Thomas\RealTimeIncidents\Domain\Events\IncidentWasAdded;
use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;

final class IncidentWasAddedProjection extends InteractsWithDynamoDb
{
    public function applyIncidentWasAdded(IncidentWasAdded $event): void
    {
        $item = [
            'PK'      => (string) $event->id(),
            'SKe'     => 'RTI',
            'istatus' => (string) $event->status(),
            'body'    => (string) $event->body(),
        ];

        $this->db->putItem([
            'Item'      => $this->marshaler->marshalItem($item),
            'TableName' => $this->tableName,
        ]);
    }
}
