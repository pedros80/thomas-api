<?php

declare(strict_types=1);

namespace Thomas\Stations\Application\Queries;

use Thomas\Shared\Domain\CRS;

interface GetStationMessages
{
    public function get(CRS $code): array;
}
