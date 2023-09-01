<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use JsonSerializable;
use Thomas\Boards\Domain\Exceptions\InvalidBoardType;

final class BoardType implements JsonSerializable
{
    public const DEPARTURES = 'Departures';
    public const ARRIVALS   = 'Arrivals';
    public const PLATFORM   = 'Platform';

    private const VALID = [
        self::DEPARTURES,
        self::ARRIVALS,
        self::PLATFORM,
    ];

    public function __construct(
        private string $type
    ) {
        if (!in_array($type, self::VALID)) {
            throw InvalidBoardType::fromString($type);
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
