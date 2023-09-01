<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use JsonSerializable;

final class AssetId implements JsonSerializable
{
    public function __construct(
        private int $id
    ) {
    }

    public function value(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
