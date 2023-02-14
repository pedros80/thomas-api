<?php

namespace Thomas\Users\Domain;

final class PasswordHash
{
    public function __construct(
        private string $hash
    ) {
    }

    public function __toString(): string
    {
        return $this->hash;
    }
}
