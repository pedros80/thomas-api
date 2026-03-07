<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Application\Commands;

use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Application\Command;

final class UpdateIncident extends Command
{
    public function __construct(
        public readonly IncidentID $id,
        public readonly IncidentMessageStatus $status,
        public readonly Body $body
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'     => $this->id,
            'status' => $this->status,
            'body'   => $this->body,
        ];
    }
}
