<?php

declare(strict_types=1);

namespace Thomas\Boards\Application\Queries;

use stdClass;
use Thomas\Boards\Domain\BoardService;

final class GetPlatformBoardDepartures
{
    public function __construct(
        private BoardService $service
    ) {
    }

    public function get(string $station, string $platform): stdClass
    {
        return $this->service->departuresPlatform($station, $platform);
    }
}
