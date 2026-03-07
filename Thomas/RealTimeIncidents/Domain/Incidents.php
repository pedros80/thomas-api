<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain;

use Thomas\Shared\Domain\TypedCollection;

final class Incidents extends TypedCollection
{
    protected string $type = Incident::class;
}
