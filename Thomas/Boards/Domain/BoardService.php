<?php

namespace Thomas\Boards\Domain;

use stdClass;

interface BoardService
{
    public function departures(string $station): stdClass;
    public function arrivals(string $station): stdClass;
    public function departuresPlatform(string $station, string $platform): stdClass;
}
