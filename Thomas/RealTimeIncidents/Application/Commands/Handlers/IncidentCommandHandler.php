<?php

namespace Thomas\RealTimeIncidents\Application\Commands\Handlers;

use Broadway\CommandHandling\SimpleCommandHandler;
use Thomas\RealTimeIncidents\Domain\IncidentsRepository;
use Thomas\Shared\Application\CommandHandler;

abstract class IncidentCommandHandler extends SimpleCommandHandler implements CommandHandler
{
    public function __construct(
        protected IncidentsRepository $incidents
    ) {
    }
}
