<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain\Exceptions;

use Exception;

final class InvalidSeverity extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromInt(int $int): InvalidSeverity
    {
        return new InvalidSeverity("'{$int}' is not a valid message severity.");
    }
}
