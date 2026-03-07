<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain\Events;

use stdClass;
use Thomas\Shared\Domain\Event;
use Thomas\Stations\Domain\MessageID;

use function Safe\json_decode;

final class MessageWasRemoved extends Event
{
    public function __construct(
        public readonly MessageID $id
    ) {
    }

    public function toArray(): array
    {
        return ['id' => $this->id];
    }

    public static function deserialize(string $json): static
    {
        /** @var stdClass $payload */
        $payload = json_decode($json);

        return new MessageWasRemoved(new MessageID($payload->id));
    }
}
