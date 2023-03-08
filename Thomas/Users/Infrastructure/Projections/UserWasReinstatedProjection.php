<?php

declare(strict_types=1);

namespace Thomas\Users\Infrastructure\Projections;

use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Users\Domain\Events\UserWasReinstated;

final class UserWasReinstatedProjection extends InteractsWithDynamoDb
{
    public function applyUserWasReinstated(UserWasReinstated $event): void
    {
        $this->db->deleteItem([
            'Key'    => $this->marshaler->marshalItem([
                'PK'  => (string) $event->email(),
                'SKe' => "US:{$event->existingId()}",
            ]),
            'TableName' => $this->tableName,
        ]);

        $item = [
            'PK'    => (string) $event->email(),
            'SKe'   => "US:{$event->userId()}",
            'uname' => (string) $event->name(),
        ];

        $this->db->putItem([
            'Item'      => $this->marshaler->marshalItem($item),
            'TableName' => $this->tableName,
        ]);
    }
}
