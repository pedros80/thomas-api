<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Application\Queries;

interface GetIncidents
{
    public function get(): array;
}
