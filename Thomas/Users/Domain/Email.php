<?php

declare(strict_types=1);

namespace Thomas\Users\Domain;

use Thomas\Users\Domain\Exceptions\InvalidEmail;

final class Email
{
    public function __construct(
        private string $value
    ) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmail::fromString($value);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
