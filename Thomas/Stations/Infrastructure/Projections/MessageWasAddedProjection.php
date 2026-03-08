<?php

declare(strict_types=1);

namespace Thomas\Stations\Infrastructure\Projections;

use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Stations\Domain\Events\MessageWasAdded;
use Thomas\Stations\Domain\Station;

final class MessageWasAddedProjection extends InteractsWithDynamoDb
{
    public function applyMessageWasAdded(MessageWasAdded $event): void
    {
        /** @var Station $station */
        foreach ($event->stations as $station) {
            if ((string) $event->body) {
                $item = [
                    'PK'       => (string) $event->id,
                    'SKe'      => "SM:{$station->code}",
                    'body'     => (string) $event->body,
                    'severity' => $event->severity->value,
                    'category' => $event->category->value,
                ];

                $this->db->putItem([
                    'Item'      => $this->marshaler->marshalItem($item),
                    'TableName' => $this->tableName,
                ]);
            }
        }
    }
}
