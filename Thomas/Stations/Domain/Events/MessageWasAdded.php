<?php

namespace Thomas\Stations\Domain\Events;

use Thomas\Shared\Domain\Event;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;

final class MessageWasAdded extends Event
{
    public function __construct(
        private MessageID $id,
        private MessageCategory $category,
        private MessageBody $body,
        private MessageSeverity $severity,
        private array $stations
    ) {
    }

    public function id(): MessageID
    {
        return $this->id;
    }

    public function category(): MessageCategory
    {
        return $this->category;
    }

    public function body(): MessageBody
    {
        return $this->body;
    }

    public function severity(): MessageSeverity
    {
        return $this->severity;
    }

    public function stations(): array
    {
        return $this->stations;
    }

    public function toArray(): array
    {
        return [
            'id'       => (string) $this->id,
            'category' => (string) $this->category,
            'body'     => (string) $this->body,
            'severity' => $this->severity->toInt(),
            'stations' => $this->stations,
        ];
    }

    public static function deserialize(string $json): static
    {
        $payload = json_decode($json);

        $stations = [];
        foreach ($payload->stations as $station) {
            $stations[] = new Station(new Code($station->code), new Name($station->name));
        }

        return new MessageWasAdded(
            new MessageID($payload->id),
            new MessageCategory($payload->category),
            new MessageBody($payload->body),
            new MessageSeverity($payload->severity),
            $stations
        );
    }
}
