<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Application\Queries;

use Thomas\RealTimeIncidents\Domain\Incidents;

interface GetIncidents
{
    public function get(array $operators = []): Incidents;
}
