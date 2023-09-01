<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain\Exceptions;

use Exception;
use Thomas\LiftsAndEscalators\Domain\SensorId;

final class SensorNotFound extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 404);
    }

    public static function fromId(SensorId $id): SensorNotFound
    {
        return new SensorNotFound("Sensor '{$id}' not found.");
    }
}
