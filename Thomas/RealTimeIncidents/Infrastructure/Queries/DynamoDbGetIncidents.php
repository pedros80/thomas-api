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
        $params = [
            'TableName'                => $this->tableName,
            'IndexName'                => 'EType',
            'KeyConditionExpression'   => "EType=:EType",
            'ExpressionAttributeValues' => [
                ':EType' => [
                    'S' => 'RTI',
                ],
            ],
        ];

        return array_map(
            function (array $item) {

                /** @var array $data */
                $data = $this->marshaler->unmarshalItem($item);

                return new Incident(
                    new IncidentID($data['PK']),
                    new IncidentMessageStatus($data['istatus']),
                    new Body($data['body'])
                );
            },
            $this->getItemsRecursively($params)
        );
    }
}
