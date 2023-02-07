<?php

namespace Thomas\RealTimeIncidents\Infrastructure\Projections;

use Illuminate\Support\Facades\Log;
use Thomas\RealTimeIncidents\Domain\Events\IncidentWasAdded;
use Thomas\Shared\Infrastructure\Projector;

final class IncidentWasAddedProjection extends Projector
{
    public function applyIncidentWasAdded(IncidentWasAdded $event): void
    {
        $item = [
            'PK'      => (string) $event->id(),
            'EType'   => 'RTI',
            'istatus' => (string) $event->status(),
            'body'    => (string) $event->body(),
        ];

        $this->client->putItem([
            'Item'      => $this->marshaler->marshalItem($item),
            'TableName' => $this->tableName,
        ]);
    }
}
