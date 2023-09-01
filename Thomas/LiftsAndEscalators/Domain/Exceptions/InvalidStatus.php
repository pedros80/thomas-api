<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain\Exceptions;

use Exception;

final class InvalidStatus extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $string): InvalidStatus
    {
        return new InvalidStatus("'{$string}' is not a valid Status");
    }
}
