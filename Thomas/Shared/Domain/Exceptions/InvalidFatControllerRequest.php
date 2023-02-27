<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Exceptions;

use Exception;

final class InvalidFatControllerRequest extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function default(): InvalidFatControllerRequest
    {
        return new InvalidFatControllerRequest('You have caused confusion and delay.');
    }
}
