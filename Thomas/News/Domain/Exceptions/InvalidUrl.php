<?php

namespace Thomas\News\Domain\Exceptions;

use Exception;

final class InvalidUrl extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $string): InvalidUrl
    {
        return new InvalidUrl("'{$string}' is not a valid URL");
    }
}
