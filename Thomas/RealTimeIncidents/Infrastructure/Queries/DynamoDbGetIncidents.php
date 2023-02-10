<?php

namespace Thomas\RealTimeIncidents\Infrastructure\Queries;

use Thomas\RealTimeIncidents\Application\Queries\GetIncidents;
use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\Incident;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;

final class DynamoDbGetIncidents extends InteractsWithDynamoDb implements GetIncidents
{
    public function get(): array
    {
        return array_map(
            fn (array $item) => $this->itemToIncident($item),
            $this->getItemsRecursively([
                'TableName'                 => $this->tableName,
                'IndexName'                 => 'SKe',
                'KeyConditionExpression'    => "#SKe=:SKe",
                'ExpressionAttributeNames'  => ['#SKe' => 'SKe'],
                'ExpressionAttributeValues' => [':SKe' => ['S' => 'RTI']],
            ])
        );
    }

    private function itemToIncident(array $item): Incident
    {
        /** @var array $data */
        $data = $this->marshaler->unmarshalItem($item);

        return new Incident(
            new IncidentID($data['PK']),
            new IncidentMessageStatus($data['istatus']),
            new Body($data['body'])
        );
    }
}
