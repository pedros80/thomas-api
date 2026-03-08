<?php

declare(strict_types=1);

namespace Thomas\Stations\Application\Queries;

use Thomas\Shared\Domain\CRS;
use Thomas\Stations\Domain\Messages;

interface GetStationMessages
{
    public function get(CRS $code): Messages;
}
