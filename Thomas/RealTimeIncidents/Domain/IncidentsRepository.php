<?php

namespace Thomas\RealTimeIncidents\Domain;

use Thomas\RealTimeIncidents\Domain\Entities\Incident;
use Thomas\RealTimeIncidents\Domain\IncidentID;

interface IncidentsRepository
{
    public function find(IncidentID $id): Incident;
    public function save(Incident $incident): void;
}
