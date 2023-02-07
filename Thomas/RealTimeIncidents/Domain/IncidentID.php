<?php

namespace Thomas\RealTimeIncidents\Domain;

use Thomas\RealTimeIncidents\Domain\Exceptions\InvalidIncidentID;

final class IncidentID
{
    public function __construct(
        private string $id
    ) {
        if (strlen($id) !== 32) {
            throw InvalidIncidentID::fromString($id);
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
