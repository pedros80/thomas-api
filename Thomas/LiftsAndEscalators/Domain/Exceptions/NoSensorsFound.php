<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain\Exceptions;

use Exception;

final class NoSensorsFound extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 404);
    }

    public static function fromOffset(int $offset): NoSensorsFound
    {
        return new NoSensorsFound("No Sensors found for offset {$offset}");
    }
}
