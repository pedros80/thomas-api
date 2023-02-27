<?php

declare(strict_types=1);

namespace Thomas\Stations\Application\Queries;

use Thomas\Stations\Domain\StationService;

final class SearchStations
{
    public function __construct(
        private StationService $service
    ) {
    }

    public function get(string $search): array
    {
        return $this->service->search($search);
    }
}
