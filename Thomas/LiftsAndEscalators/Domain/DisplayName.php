<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use JsonSerializable;

final class DisplayName implements JsonSerializable
{
    public function __construct(
        private string $displayName
    ) {
    }

    public function __toString(): string
    {
        return $this->displayName;
    }

    public function jsonSerialize(): mixed
    {
        return (string) $this;
    }
}
