<?php

declare(strict_types=1);

namespace Thomas\Stations\Application\Queries;

interface GetStationMessages
{
    public function get(string $code): array;
}
