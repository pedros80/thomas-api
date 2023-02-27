<?php

declare(strict_types=1);

namespace Thomas\Stations\Infrastructure\Projections;

use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Stations\Domain\Events\MessageWasUpdated;

final class MessageWasUpdatedProjection extends InteractsWithDynamoDb
{
    public function applyMessageWasUpdated(MessageWasUpdated $event): void
    {
        $this->deleteExisting($this->getExisting($event));
        $this->addRecordPerStation($event);
    }

    private function getExisting(MessageWasUpdated $event): array
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

    private function addRecordPerStation(MessageWasUpdated $event): void
    {
        foreach ($event->stations() as $station) {
            if ($event->severity()->toInt() > 0 && (string) $event->body()) {
                $item = [
                    'PK'       => (string) $event->id(),
                    'SKe'      => "SM:{$station->toArray()['code']}",
                    'body'     => (string) $event->body(),
                    'severity' => $event->severity()->toInt(),
                    'category' => (string) $event->category(),
                ];

                $this->db->putItem([
                    'Item'      => $this->marshaler->marshalItem($item),
                    'TableName' => $this->tableName,
                ]);
            }
        }
    }
}
