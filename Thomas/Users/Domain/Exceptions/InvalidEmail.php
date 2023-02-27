<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Exceptions;

use Exception;

final class InvalidEmail extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $string): InvalidEmail
    {
        return new InvalidEmail("'{$string}' is not a valid email address.");
    }
}
