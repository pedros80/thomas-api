<?php

namespace Thomas\RealTimeIncidents\Application\Commands;

use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\Shared\Application\Command;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;

final class AddIncident implements Command
{
    public function __construct(
        private IncidentID $id,
        private IncidentMessageStatus $status,
        private Body $body
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

    public function body(): Body
    {
        return $this->body;
    }
}
