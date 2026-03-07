<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain;

use Thomas\RealTimeIncidents\Domain\Entities\Incident;
use Thomas\RealTimeIncidents\Domain\IncidentId;

interface IncidentsRepository
{
    public function find(IncidentId $id): Incident;
    public function save(Incident $incident): void;
}
