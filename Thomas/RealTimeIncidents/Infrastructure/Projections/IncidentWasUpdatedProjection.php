<?php

namespace Thomas\RealTimeIncidents\Infrastructure\Projections;

use Thomas\RealTimeIncidents\Domain\Events\IncidentWasUpdated;
use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;

final class IncidentWasUpdatedProjection extends InteractsWithDynamoDb
{
    public function applyIncidentWasUpdated(IncidentWasUpdated $event): void
    {
        $this->db->updateItem([
            'TableName' => $this->tableName,
            'Key'       => $this->marshaler->marshalItem([
                'PK'  => (string) $event->id(),
                'SKe' => 'RTI',
            ]),
            'UpdateExpression'          => 'set istatus=:Status, body=:Body',
            'ExpressionAttributeValues' => $this->marshaler->marshalItem([
                ':Status' => (string) $event->status(),
                ':Body'   => (string) $event->body(),
            ]),
        ]);
    }
}
