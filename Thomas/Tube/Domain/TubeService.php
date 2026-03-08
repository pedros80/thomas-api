<?php

declare(strict_types=1);

namespace Thomas\Tube\Domain;

use Thomas\Shared\Domain\NaptanId;
use Thomas\Tube\Domain\Arrivals;
use Thomas\Tube\Domain\TubeLineId;

interface TubeService
{
    public function getTubeLines(): array;
    public function getArrivalsByNaptan(NaptanId $naptanId): Arrivals;
    public function getNaptansByLine(TubeLineId $line): array;
}
