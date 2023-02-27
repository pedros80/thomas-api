<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain\Exceptions;

use Exception;

final class InvalidIncidentMessageStatus extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $string): InvalidIncidentMessageStatus
    {
        return new InvalidIncidentMessageStatus("'{$string}' is not a valid Incident Message Status");
    }
}
