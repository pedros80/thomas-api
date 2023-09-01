<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Exceptions;

use Exception;

final class InvalidCRS extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromCode(string $code): InvalidCRS
    {
        return new InvalidCRS("{$code} is not a valid CRS.");
    }
}
