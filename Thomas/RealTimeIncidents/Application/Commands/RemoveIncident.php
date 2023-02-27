<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Application\Commands;

use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Application\Command;

final class RemoveIncident extends Command
{
    public function __construct(
        private IncidentID $id,
        private IncidentMessageStatus $status
    ) {
    }

    public function id(): IncidentID
    {
        return $this->id;
    }

    public function status(): IncidentMessageStatus
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'id'     => (string) $this->id,
            'status' => (string) $this->status,
        ];
    }
}
