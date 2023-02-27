<?php

declare(strict_types=1);

namespace Thomas\Stations\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Stations\Domain\MessageID;

final class RemoveStationMessage extends Command
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
        return [
            'id' => (string) $this->id,
        ];
    }
}
