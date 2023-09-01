<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain\Exceptions;

use Exception;

final class InvalidAssetType extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $string): InvalidAssetType
    {
        return new InvalidAssetType("'{$string}' is not a valid Asset Type");
    }
}
