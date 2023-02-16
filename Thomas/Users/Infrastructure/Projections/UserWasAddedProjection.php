<?php

namespace Thomas\Users\Infrastructure\Projections;

use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Users\Domain\Events\UserWasAdded;

final class UserWasAddedProjection extends InteractsWithDynamoDb
{
    public function applyUserWasAdded(UserWasAdded $event): void
    {
        $item = [
            'PK'   => (string) $event->email(),
            'SKe'  => "US:{$event->userId()}",
            'name' => (string) $event->name(),
        ];

        $this->db->putItem([
            'Item'      => $this->marshaler->marshalItem($item),
            'TableName' => $this->tableName,
        ]);
    }
}
