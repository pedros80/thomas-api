<?php

namespace Thomas\RealTimeIncidents\Application\Commands;

use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\Incident;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Application\Command;

final class CommandFactory
{
    public function fromIncident(Incident $incident): Command
    {
        return match ($incident->status()) {
            IncidentMessageStatus::new() => $this->makeAddIncident($incident),
            IncidentMessageStatus::modified() => $this->makeUpdateIncident($incident),
            default => $this->makeRemoveIncident($incident),
        };
    }

    private function makeAddIncident(Incident $incident): AddIncident
    {
        /** @var Body $body */
        $body   = $incident->body();
        $id     = $incident->id();
        $status = $incident->status();

        return new AddIncident($id, $status, $body);
    }

    private function makeUpdateIncident(Incident $incident): UpdateIncident
    {
        /** @var Body $body */
        $body   = $incident->body();
        $id     = $incident->id();
        $status = $incident->status();

        return new UpdateIncident($id, $status, $body);
    }

    private function makeRemoveIncident(Incident $incident): RemoveIncident
    {
        $id     = $incident->id();
        $status = $incident->status();

        return new RemoveIncident($id, $status);
    }
}
