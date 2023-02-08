<?php

namespace Thomas\RealTimeIncidents\Application\Commands\Handlers;

use Thomas\RealTimeIncidents\Application\Commands\Handlers\IncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\RemoveIncident;
use Thomas\RealTimeIncidents\Domain\Exceptions\IncidentNotFound;
use Thomas\Shared\Infrastructure\Exceptions\EventStreamNotFound;

final class RemoveIncidentCommandHandler extends IncidentCommandHandler
{
    public function handleRemoveIncident(RemoveIncident $command): void
    {
        try {
            $incident = $this->incidents->find($command->id());
        } catch (EventStreamNotFound | IncidentNotFound) {
            // maybe we receive a removed incident event without knowing of incident before
            // just bail
            return;
        }

        $incident->remove($command->id(), $command->status());

        $this->incidents->save($incident);
    }
}
