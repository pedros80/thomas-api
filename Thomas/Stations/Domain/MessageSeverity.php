<?php

namespace Thomas\Stations\Domain;

use Thomas\Stations\Domain\Exceptions\InvalidSeverity;

final class MessageSeverity
{
    public const NORMAL = 0;
    public const MINOR  = 1;
    public const MAJOR  = 2;
    public const SEVERE = 3;

    public const LABELS = [
        'normal',
        'minor',
        'major',
        'severe',
    ];

    public function __construct(
        private int $severity
    ) {
        if ($severity < 0 || $severity > 3) {
            throw InvalidSeverity::fromInt($severity);
        }
    }

    public function __toString(): string
    {
        return self::LABELS[$this->severity];
    }

    public function toInt(): int
    {
        return $this->severity;
    }
}
