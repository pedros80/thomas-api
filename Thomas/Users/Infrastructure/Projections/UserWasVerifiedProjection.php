<?php

namespace Thomas\Users\Infrastructure\Projections;

use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Users\Domain\Events\UserWasVerified;

final class UserWasVerifiedProjection extends InteractsWithDynamoDb
{
    public function applyUserWasVerified(UserWasVerified $event): void
    {
        $this->db->deleteItem([
            'Key'    => $this->marshaler->marshalItem([
                'PK'  => (string) $event->userId(),
                'SKe' => "VT:{$event->verifyToken()}",
            ]),
            'TableName' => $this->tableName,
        ]);
    }
}
