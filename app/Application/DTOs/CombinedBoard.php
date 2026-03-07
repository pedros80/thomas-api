<?php

declare(strict_types=1);

namespace App\Application\DTOs;

use Illuminate\Contracts\Support\Arrayable;
use Thomas\Boards\Domain\Board;
use Thomas\RealTimeIncidents\Domain\Incidents;
use Thomas\Stations\Domain\Messages;

final class CombinedBoard implements Arrayable
{
    public function __construct(
        public readonly Board $board,
        public readonly Messages $messages,
        public readonly Incidents $incidents,
    ) {
    }

    public function toArray(): array
    {
        return [
            'board'     => $this->board,
            'messages'  => $this->messages,
            'incidents' => $this->incidents,
        ];
    }
}
