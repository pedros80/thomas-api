<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain\Exceptions;

use Exception;

final class InvalidMessageCategory extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $string): InvalidMessageCategory
    {
        return new InvalidMessageCategory("'{$string}' is not a valid message category.");
    }
}
