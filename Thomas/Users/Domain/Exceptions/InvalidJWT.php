<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Exceptions;

use Exception;

final class InvalidJWT extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 401);
    }

    public static function create(): InvalidJWT
    {
        return new InvalidJWT('JWT is missing or invalid; please try again.');
    }
}
