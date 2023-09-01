<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

final class Token
{
    public function __construct(
        private string $token
    ) {
    }

    public function __toString(): string
    {
        return $this->token;
    }
}
