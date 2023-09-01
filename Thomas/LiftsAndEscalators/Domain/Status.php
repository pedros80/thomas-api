<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use JsonSerializable;
use Thomas\LiftsAndEscalators\Domain\Exceptions\InvalidStatus;

final class Status implements JsonSerializable
{
    public const AVAILABLE     = 'Available';
    public const UNKNOWN       = 'Unknown';
    public const NOT_AVAILABLE = 'Not Available';

    private const VALID = [
        self::AVAILABLE,
        self::UNKNOWN,
        self::NOT_AVAILABLE,
    ];

    public function __construct(
        private string $status
    ) {
        if (!in_array($status, self::VALID)) {
            throw InvalidStatus::fromString($status);
        }
    }

    public function __toString(): string
    {
        return $this->status;
    }

    public function jsonSerialize(): mixed
    {
        return (string) $this;
    }
}
