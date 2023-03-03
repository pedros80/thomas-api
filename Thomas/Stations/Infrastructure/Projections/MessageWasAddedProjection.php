<?php

declare(strict_types=1);

namespace Thomas\Stations\Infrastructure\Projections;

use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Stations\Domain\Events\MessageWasAdded;

final class MessageWasAddedProjection extends InteractsWithDynamoDb
{
    public function applyMessageWasAdded(MessageWasAdded $event): void
    {
        foreach ($event->stations() as $station) {
            if ((string) $event->body()) {
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
