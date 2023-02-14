<?php

namespace Thomas\Users\Infrastructure\Projections;

use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Users\Domain\Events\UserWasRegistered;

final class UserWasRegisteredProjection extends InteractsWithDynamoDb
{
    public function applyUserWasRegistered(UserWasRegistered $event): void
    {
        $item = [
            'PK'   => (string) $event->email(),
            'SKe'  => "US:{$event->userId()}",
            'name' => (string) $event->name(),
            'hash' => (string) $event->passwordHash(),
        ];

        $this->db->putItem([
            'Item'      => $this->marshaler->marshalItem($item),
            'TableName' => $this->tableName,
        ]);

        $item = [
            'PK'    => (string) $event->userId(),
            'SKe'   => "VT:{$event->verifyToken()}",
            'email' => (string) $event->email(),
        ];

        $this->db->putItem([
            'Item'      => $this->marshaler->marshalItem($item),
            'TableName' => $this->tableName,
        ]);
    }
}
