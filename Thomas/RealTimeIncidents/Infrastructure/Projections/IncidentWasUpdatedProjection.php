<?php

namespace Thomas\RealTimeIncidents\Infrastructure\Projections;

use Thomas\RealTimeIncidents\Domain\Events\IncidentWasUpdated;
use Thomas\Shared\Infrastructure\Projector;

final class IncidentWasUpdatedProjection extends Projector
{
    public function applyIncidentWasUpdated(IncidentWasUpdated $event): void
    {
        $this->client->updateItem([
            'TableName' => $this->tableName,
            'Key'    => $this->marshaler->marshalItem([
                'PK'    => (string) $event->id(),
                'EType' => 'RTI',
            ]),
            'UpdateExpression'          => 'set istatus=:Status, body=:Body',
            'ExpressionAttributeValues' => $this->marshaler->marshalItem([
                ':Status' => (string) $event->status(),
                ':Body'   => (string) $event->body(),
            ]),
        ]);
    }
}
