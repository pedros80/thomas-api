<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Exceptions;

use Exception;

final class InvalidTypeForCollection extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromClass(string $fqcn): InvalidTypeForCollection
    {
        return new InvalidTypeForCollection("Object should be {$fqcn}.");
    }
}
