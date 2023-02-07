<?php

declare(strict_types=1);

namespace Thomas\Shared\Infrastructure;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\ReadModel\Projector as BroadwayProjector;

abstract class Projector extends BroadwayProjector
{
    public function __construct(
        protected DynamoDbClient $client,
        protected Marshaler $marshaler,
        protected string $tableName
    ) {
    }
}
