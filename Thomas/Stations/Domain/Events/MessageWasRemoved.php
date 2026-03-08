<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain\Events;

use Thomas\Shared\Domain\Event;
use Thomas\Stations\Domain\MessageId;

use function Safe\json_decode;

final class MessageWasRemoved extends Event
{
    public function __construct(
        public readonly MessageId $id,
    ) {
    }

    public function toArray(): array
    {
        return ['id' => $this->id];
    }

    public static function deserialize(string $json): static
    {
        /** @var array $payload */
        $payload = json_decode($json, true);

        return new MessageWasRemoved(
            new MessageId($payload['id']),
        );
    }
}
