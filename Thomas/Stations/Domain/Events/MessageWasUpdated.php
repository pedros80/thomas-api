<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain\Events;

use Thomas\Shared\Domain\Event;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageId;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Stations;

use function Safe\json_decode;

final class MessageWasUpdated extends Event
{
    public function __construct(
        public readonly MessageId $id,
        public readonly MessageCategory $category,
        public readonly MessageBody $body,
        public readonly MessageSeverity $severity,
        public readonly Stations $stations,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'category' => $this->category,
            'body'     => $this->body,
            'severity' => $this->severity,
            'stations' => $this->stations,
        ];
    }

    public static function deserialize(string $json): static
    {
        /** @var array $payload */
        $payload = json_decode($json, true);

        return new MessageWasUpdated(
            new MessageId($payload['id']),
            MessageCategory::from($payload['category']),
            new MessageBody($payload['body']),
            MessageSeverity::from($payload['severity']),
            Stations::fromArray($payload['stations']),
        );
    }
}
