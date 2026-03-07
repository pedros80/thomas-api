<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Application\Commands;

use Thomas\RealTimeIncidents\Domain\IncidentId;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Application\Command;

final class RemoveIncident extends Command
{
    public function __construct(
        public readonly IncidentId $id,
        public readonly IncidentMessageStatus $status,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'     => $this->id,
            'status' => $this->status,
        ];
    }
}
