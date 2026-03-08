<?php

declare(strict_types=1);

namespace Thomas\Stations\Application\Queries;

use Thomas\Stations\Domain\Stations;
use Thomas\Stations\Domain\StationService;

final class SearchStations
{
    public function __construct(
        private readonly StationService $service
    ) {
    }

    public function get(string $search): Stations
    {
        return $this->service->search($search);
    }
}
