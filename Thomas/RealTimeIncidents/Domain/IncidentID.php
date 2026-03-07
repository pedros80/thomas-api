<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain;

use Thomas\RealTimeIncidents\Domain\Exceptions\InvalidIncidentId;
use Thomas\Shared\Domain\StringValue;

final class IncidentId extends StringValue
{
    public function __construct(
        protected readonly string $value
    ) {
        if (strlen($value) !== 32) {
            throw InvalidIncidentId::fromString($value);
        }
    }
}
