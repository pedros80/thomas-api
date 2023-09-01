<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain\Exceptions;

use Exception;

final class InvalidBoardType extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $string): InvalidBoardType
    {
        return new InvalidBoardType("'{$string}' is not a valid Board Type");
    }
}
