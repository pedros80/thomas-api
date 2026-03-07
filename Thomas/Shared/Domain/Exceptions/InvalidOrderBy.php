<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Exceptions;

use Exception;

final class InvalidOrderBy extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromOrderBy(string $orderBy): InvalidOrderBy
    {
        return new InvalidOrderBy("{$orderBy} is not a valid Order By");
    }
}
