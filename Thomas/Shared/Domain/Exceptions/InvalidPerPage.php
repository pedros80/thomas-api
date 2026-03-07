<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Exceptions;

use Exception;

final class InvalidPerPage extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromNumber(int $number): InvalidPerPage
    {
        return new InvalidPerPage("Invalid PerPage {$number} - must be greater than 0");
    }
}
