<?php

namespace Thomas\RealTimeIncidents\Application\Commands\Handlers;

use Thomas\RealTimeIncidents\Application\Commands\Handlers\IncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\UpdateIncident;
use Thomas\RealTimeIncidents\Domain\Entities\Incident;
use Thomas\RealTimeIncidents\Domain\Exceptions\IncidentNotFound;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;

final class UpdateIncidentCommandHandler extends IncidentCommandHandler
{
    public function handleUpdateIncident(UpdateIncident $command): void
    {
        try {
            $incident = $this->incidents->find($command->id());
        } catch (IncidentNotFound) {
            // maybe we're picking up a modify event for an incident we've missed...

            $incident = Incident::add(
                $command->id(),
                IncidentMessageStatus::new(),
                $command->body()
            );

            $this->incidents->save($incident);
        }

        $incident->update(
            $command->id(),
            $command->status(),
            $command->body()
        );

        $this->incidents->save($incident);
    }
}
