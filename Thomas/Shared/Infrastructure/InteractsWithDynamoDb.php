<?php

declare(strict_types=1);

namespace Thomas\Shared\Infrastructure;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;

abstract class InteractsWithDynamoDb
{
    public function __construct(
        protected DynamoDbClient $db,
        protected Marshaler $marshaler,
        protected string $tableName
    ) {
    }

    protected function getItemsRecursively(array $params, array $items = []): array
    {
        $result = $this->db->query($params);
        $items  = array_merge($items, $result['Items']);

        if (isset($result['LastEvaluatedKey'])) {
            $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
            return $this->getItemsRecursively($params, $items);
        }

        return $items;
    }

    protected function scanItemsRecursively(array $params, array $items = []): array
    {
        $result = $this->db->scan($params);
        $items  = array_merge($items, $result['Items']);

        if (isset($result['LastEvaluatedKey'])) {
            $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
            return $this->scanItemsRecursively($params, $items);
        }

        return $items;
    }
}
