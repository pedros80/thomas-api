<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain\Events;

use stdClass;
use Thomas\Shared\Domain\Event;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;
use Thomas\Stations\Domain\Stations;

use function Safe\json_decode;

final class MessageWasUpdated extends Event
{
    public function __construct(
        public readonly MessageID $id,
        public readonly MessageCategory $category,
        public readonly MessageBody $body,
        public readonly MessageSeverity $severity,
        public readonly Stations $stations
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
        /** @var stdClass $payload */
        $payload = json_decode($json);

        $stations = [];

        foreach ($payload->stations as $station) {
            $stations[] = new Station(new Code($station->code), new Name($station->name));
        }

        return new MessageWasUpdated(
            new MessageID($payload->id),
            MessageCategory::from($payload->category),
            new MessageBody($payload->body),
            MessageSeverity::from($payload->severity),
            new Stations($stations)
        );
    }
}
