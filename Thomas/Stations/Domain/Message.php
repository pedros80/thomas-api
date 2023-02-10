<?php

namespace Thomas\Stations\Domain;

use JsonSerializable;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;

final class Message implements JsonSerializable
{
    public function __construct(
        private MessageID $id,
        private MessageCategory $category,
        private MessageBody $body,
        private MessageSeverity $severity,
        private array $stations
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'       => (string) $this->id,
            'category' => (string) $this->category,
            'body'     => (string) $this->body,
            'severity' => (string) $this->severity,
            'stations' => $this->stations,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
