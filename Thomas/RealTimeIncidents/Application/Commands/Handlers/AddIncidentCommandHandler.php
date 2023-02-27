<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Application\Commands\Handlers;

use Thomas\RealTimeIncidents\Application\Commands\AddIncident;
use Thomas\RealTimeIncidents\Application\Commands\Handlers\IncidentCommandHandler;
use Thomas\RealTimeIncidents\Domain\Entities\Incident;

final class AddIncidentCommandHandler extends IncidentCommandHandler
{
    public function handleAddIncident(AddIncident $command): void
    {
        $incident = Incident::add(
            $command->id(),
            $command->status(),
            $command->body()
        );

        $this->incidents->save($incident);
    }
}
