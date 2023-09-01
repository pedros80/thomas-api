<?php

declare(strict_types=1);

namespace Thomas\Boards\Application\Queries;

use Thomas\Boards\Domain\Board;
use Thomas\Boards\Domain\BoardDataService;
use Thomas\Shared\Domain\CRS;

final class GetStationBoardDepartures
{
    public function __construct(
        private BoardDataService $service
    ) {
    }

    public function get(CRS $station): Board
    {
        return $this->service->departures($station);
    }
}
