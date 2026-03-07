<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain\Exceptions;

use Exception;

final class InvalidIncidentId extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $string): InvalidIncidentId
    {
        return new InvalidIncidentId("'{$string}' is not a valid Incident ID");
    }
}
