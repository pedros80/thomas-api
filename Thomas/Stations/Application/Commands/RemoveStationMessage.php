<?php

declare(strict_types=1);

namespace Thomas\Stations\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Stations\Domain\MessageId;

final class RemoveStationMessage extends Command
{
    public function __construct(
        public readonly MessageId $id,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
