<?php

namespace Thomas\RealTimeIncidents\Application\Commands\Handlers;

use Thomas\RealTimeIncidents\Application\Commands\Handlers\IncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\UpdateIncident;

final class UpdateIncidentCommandHandler extends IncidentCommandHandler
{
    public function handleUpdateIncident(UpdateIncident $command): void
    {
        $incident = $this->incidents->find($command->id());

        $incident->update(
            $command->id(),
            $command->status(),
            $command->body()
        );

        $this->incidents->save($incident);
    }
}
