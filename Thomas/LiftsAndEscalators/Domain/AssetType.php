<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use JsonSerializable;
use Thomas\LiftsAndEscalators\Domain\Exceptions\InvalidAssetType;

final class AssetType implements JsonSerializable
{
    public const LIFT      = 'Lift';
    public const ESCALATOR = 'Escalator';

    private const VALID = [
        self::LIFT,
        self::ESCALATOR,
    ];

    public function __construct(
        private string $type
    ) {
        if (!in_array($type, self::VALID)) {
            throw InvalidAssetType::fromString($type);
        }
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
