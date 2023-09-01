<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain\Exceptions;

use Exception;
use Thomas\LiftsAndEscalators\Domain\AssetId;

final class AssetNotFound extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 404);
    }

    public static function fromId(AssetId $id): AssetNotFound
    {
        return new AssetNotFound("Asset '{$id}' not found.");
    }
}
