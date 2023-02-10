<?php

namespace Thomas\Stations\Application\Queries;

interface GetStationMessages
{
    public function get(string $code): array;
}
