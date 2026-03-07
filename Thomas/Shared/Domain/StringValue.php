<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain;

use JsonSerializable;

abstract class StringValue implements JsonSerializable
{
    public function __construct(
        protected readonly string $value
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
