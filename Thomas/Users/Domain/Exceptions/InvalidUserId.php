<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Exceptions;

use Exception;

final class InvalidUserId extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $string): InvalidUserId
    {
        return new InvalidUserId("'{$string}' is not a valid user id.");
    }
}
