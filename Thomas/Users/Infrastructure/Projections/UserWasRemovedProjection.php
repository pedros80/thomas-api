<?php

namespace Thomas\Users\Infrastructure\Projections;

use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Users\Domain\Events\UserWasRemoved;

final class UserWasRemovedProjection extends InteractsWithDynamoDb
{
    public function applyUserWasRemoved(UserWasRemoved $event): void
    {
        $this->db->deleteItem([
            'Key'    => $this->marshaler->marshalItem([
                'PK'  => (string) $event->email(),
                'SKe' => "US:{$event->userId()}",
            ]),
            'TableName' => $this->tableName,
        ]);
    }
}
