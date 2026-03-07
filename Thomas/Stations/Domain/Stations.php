<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

use Thomas\Shared\Domain\TypedCollection;
use Thomas\Stations\Domain\Station;

final class Stations extends TypedCollection
{
    protected string $type = Station::class;
}
