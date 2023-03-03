<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Infrastructure\Queries;

use Thomas\RealTimeIncidents\Application\Queries\GetIncidents;
use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\Incident;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;

final class DynamoDbGetIncidents extends InteractsWithDynamoDb implements GetIncidents
{
    public function get(array $operators = []): array
    {
        $incidents = array_map(
            fn (array $item) => $this->itemToIncident($item),
            $this->getItemsRecursively([
                'TableName'                 => $this->tableName,
                'IndexName'                 => 'SKe',
                'KeyConditionExpression'    => '#SKe=:SKe',
                'ExpressionAttributeNames'  => ['#SKe' => 'SKe'],
                'ExpressionAttributeValues' => [':SKe' => ['S' => 'RTI']],
            ])
        );

        if (!$operators) {
            return $incidents;
        }

        return array_values(
            array_filter(
                $incidents,
                fn (Incident $incident) => array_intersect($incident->body()?->operators() ?: [], $operators)
            )
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
