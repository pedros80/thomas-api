<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use JsonSerializable;

final class Location implements JsonSerializable
{
    public function __construct(
        private string $location
    ) {
    }

    public function __toString(): string
    {
        return $this->location;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
