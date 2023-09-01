<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\RealTimeTrains\Exceptions;

use Exception;

final class InvalidServiceUid extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $string): InvalidServiceUid
    {
        return new InvalidServiceUid("'{$string}' is not a valid service id");
    }
}
