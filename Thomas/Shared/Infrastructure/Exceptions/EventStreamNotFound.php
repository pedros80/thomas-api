<?php

declare(strict_types=1);

namespace Thomas\Shared\Infrastructure\Exceptions;

use Broadway\EventStore\EventStoreException;

final class EventStreamNotFound extends EventStoreException
{
    private function __construct(string $message)
    {
        parent::__construct($message, 404);
    }

    public static function withAggregate(string $aggregateId): EventStreamNotFound
    {
        return new EventStreamNotFound("EventStream not found for aggregate with id '{$aggregateId}'");
    }
}
