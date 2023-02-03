<?php

namespace Thomas\Boards\Application\Queries;

use stdClass;
use Thomas\Boards\Domain\BoardService;

final class GetStationBoardArrivals
{
    public function __construct(
        private BoardService $service
    ) {
    }

    public function get(string $station): stdClass
    {
        return $this->service->arrivals($station);
    }
}
