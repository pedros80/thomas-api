<?php

declare(strict_types=1);

namespace Thomas\Shared\Infrastructure\Exceptions;

use Broadway\Domain\DomainEventStream;
use Broadway\EventStore\EventStoreException;

final class DuplicatePlayhead extends EventStoreException
{
    private function __construct()
    {
        parent::__construct("Duplicate Playhead in this event stream");
    }

    public static function withEventStream(DomainEventStream $eventStream): DuplicatePlayhead
    {
        return new DuplicatePlayhead();
    }
}
