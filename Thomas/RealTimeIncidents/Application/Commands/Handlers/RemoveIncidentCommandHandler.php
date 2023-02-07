<?php

namespace Thomas\RealTimeIncidents\Application\Commands\Handlers;

use Thomas\RealTimeIncidents\Application\Commands\Handlers\IncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\RemoveIncident;

final class RemoveIncidentCommandHandler extends IncidentCommandHandler
{
    public function handleRemoveIncident(RemoveIncident $command): void
    {
        $incident = $this->incidents->find($command->id());

        $incident->remove($command->id(), $command->status());

        $this->incidents->save($incident);
    }
}
