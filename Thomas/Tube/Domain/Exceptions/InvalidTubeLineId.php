<?php

declare(strict_types=1);

namespace Thomas\Tube\Domain\Exceptions;

use Exception;

final class InvalidTubeLineId extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $line): InvalidTubeLineId
    {
        return new InvalidTubeLineId("'{$line}' is not a valid Tube Line ID. Please try again.");
    }
}
