<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use JsonSerializable;

final class PRN implements JsonSerializable
{
    public function __construct(
        private int $prn
    ) {
    }

    public function jsonSerialize(): string
    {
        return (string) $this->prn;
    }
}
