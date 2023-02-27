<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain\Events;

use Thomas\Shared\Domain\Event;
use Thomas\Stations\Domain\MessageID;

final class MessageWasRemoved extends Event
{
    public function __construct(
        private MessageID $id
    ) {
    }

    public function id(): MessageID
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return ['id' => (string) $this->id];
    }

    public static function deserialize(string $json): static
    {
        $payload = json_decode($json);

        return new MessageWasRemoved(new MessageID($payload->id));
    }
}
