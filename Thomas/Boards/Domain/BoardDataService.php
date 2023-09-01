<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use Thomas\Boards\Domain\Board;
use Thomas\Shared\Domain\CRS;

interface BoardDataService
{
    public function departures(CRS $station): Board;
    public function arrivals(CRS $station): Board;
    public function departuresPlatform(CRS $station, string $platform): Board;
}
