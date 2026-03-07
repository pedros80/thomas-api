<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain;

use Thomas\RealTimeIncidents\Domain\Exceptions\InvalidIncidentID;
use Thomas\Shared\Domain\StringValue;

final class IncidentID extends StringValue
{
    public function __construct(
        protected readonly string $value
    ) {
        if (strlen($value) !== 32) {
            throw InvalidIncidentID::fromString($value);
        }
    }
}
