<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Exceptions;

use Exception;

final class InvalidSort extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $status): InvalidSort
    {
        return new InvalidSort("{$status} is not a valid Sort");
    }
}
