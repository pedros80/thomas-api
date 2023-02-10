<?php

namespace Thomas\Stations\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;

final class RecordStationMessage extends Command
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
}
