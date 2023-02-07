<?php

declare(strict_types=1);

namespace Thomas\Shared\Infrastructure\Exceptions;

use Broadway\EventStore\EventStoreException;

final class EventStreamNotFound extends EventStoreException
{
    private function __construct(string $aggregateId)
    {
        parent::__construct("EventStream not found for aggregate with id {$aggregateId}", 404);
    }

    public static function withAggregate(string $aggregateId): EventStreamNotFound
    {
        return new EventStreamNotFound($aggregateId);
    }
}
