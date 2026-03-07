<?php

declare(strict_types=1);

namespace Thomas\Stations\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageId;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Stations;

final class RecordStationMessage extends Command
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
}
