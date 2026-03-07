<?php

declare(strict_types=1);

namespace Thomas\Stations\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Stations\Domain\MessageID;

final class RemoveStationMessage extends Command
{
    public function __construct(
        public readonly MessageID $id,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
