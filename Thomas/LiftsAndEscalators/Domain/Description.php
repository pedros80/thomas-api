<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use JsonSerializable;

final class Description implements JsonSerializable
{
    public function __construct(
        private string $description
    ) {
    }

    public function __toString(): string
    {
        return $this->description;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
