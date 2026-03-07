<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain;

use JsonSerializable;

abstract class IntegerValue implements JsonSerializable
{
    public function __construct(
        protected readonly int $value,
    ) {
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function jsonSerialize(): int
    {
        return $this->value();
    }
}
