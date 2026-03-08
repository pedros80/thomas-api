<?php

declare(strict_types=1);

namespace Thomas\Users\Domain;

use Thomas\Shared\Domain\StringValue;
use Thomas\Users\Domain\Exceptions\InvalidEmail;

final class Email extends StringValue
{
    public function __construct(
        protected readonly string $value
    ) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmail::fromString($value);
        }
    }
}
