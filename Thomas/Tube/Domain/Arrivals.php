<?php

declare(strict_types=1);

namespace Thomas\Tube\Domain;

use Thomas\Shared\Domain\TypedCollection;
use Thomas\Tube\Domain\Arrival;

final class Arrivals extends TypedCollection
{
    protected string $type = Arrival::class;
}
