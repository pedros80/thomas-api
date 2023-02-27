<?php

declare(strict_types=1);

namespace Thomas\Stations\Infrastructure\Projections;

use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Stations\Domain\Events\MessageWasRemoved;

final class MessageWasRemovedProjection extends InteractsWithDynamoDb
{
    public function applyMessageWasRemoved(MessageWasRemoved $event): void
    {
        $this->deleteExisting($this->getExisting($event));
    }

    private function getExisting(MessageWasRemoved $event): array
    {
        return $this->getItemsRecursively([
            'TableName'                 => $this->tableName,
            'Limit'                     => 100,
            'KeyConditionExpression'    => '#PK = :pk AND begins_with(#SKe, :SKe)',
            'ExpressionAttributeNames'  => ['#PK'  => 'PK', '#SKe' => 'SKe'],
            'ExpressionAttributeValues' => [
                ':pk'  => ['S' => (string) $event->id()],
                ':SKe' => ['S' => 'SM:'],
            ],
        ]);
    }

    private function deleteExisting(array $existing): void
    {
        foreach ($existing as $item) {
            $this->db->deleteItem([
                'Key'       => $this->marshaler->marshalItem([
                    'PK'  => $item['PK']['S'],
                    'SKe' => $item['SKe']['S'],
                ]),
                'TableName' => $this->tableName,
            ]);
        }
    }
}
