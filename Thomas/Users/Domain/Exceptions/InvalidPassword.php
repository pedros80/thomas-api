<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Exceptions;

use Exception;

final class InvalidPassword extends Exception
{
    private function __construct(string $error)
    {
        parent::__construct($error, 400);
    }

    public static function fromString(string $error): InvalidPassword
    {
        return new InvalidPassword("Invalid Password: {$error}");
    }
}
