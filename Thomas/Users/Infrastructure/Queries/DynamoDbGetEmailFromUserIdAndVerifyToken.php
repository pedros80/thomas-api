<?php

namespace Thomas\Users\Infrastructure\Queries;

use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Users\Application\Queries\GetEmailFromUserIdAndVerifyToken;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class DynamoDbGetEmailFromUserIdAndVerifyToken extends InteractsWithDynamoDb implements GetEmailFromUserIdAndVerifyToken
{
    public function get(UserId $userId, VerifyToken $verifyToken): Email
    {
        $result = $this->db->query([
            'TableName'                 => $this->tableName,
            'KeyConditionExpression'    => "#PK=:PK AND #SKe = :SKe",
            'ExpressionAttributeNames'  => ['#PK' => 'PK', '#SKe' => 'SKe'],
            'ExpressionAttributeValues' => [
                ':PK'  => ['S' => (string) $userId],
                ':SKe' => ['S' => "VT:{$verifyToken}"]
            ],
        ]);

        if (!count($result['Items'])) {
            throw UserNotFound::fromUserId($userId);
        }

        $item = (array) $this->marshaler->unmarshalItem($result['Items'][0]);

        return new Email($item['email']);
    }
}
