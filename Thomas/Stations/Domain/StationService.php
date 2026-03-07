<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

use Thomas\Stations\Domain\Stations;

interface StationService
{
    public function search(string $search): Stations;
}
