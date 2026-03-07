<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Domain;

use Thomas\ServiceIndicator\Domain\ServiceIndicator;
use Thomas\Shared\Domain\TypedCollection;

final class ServiceIndicators extends TypedCollection
{
    protected string $type = ServiceIndicator::class;
}
