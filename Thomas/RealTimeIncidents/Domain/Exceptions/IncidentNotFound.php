<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain\Exceptions;

use Exception;
use Thomas\RealTimeIncidents\Domain\IncidentID;

final class IncidentNotFound extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 404);
    }

    public static function fromId(IncidentID $id): IncidentNotFound
    {
        return new IncidentNotFound("Incident {$id} not found.");
    }
}
