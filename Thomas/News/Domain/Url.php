<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

use Thomas\News\Domain\Exceptions\InvalidUrl;
use Thomas\Shared\Domain\StringValue;

final class Url extends StringValue
{
    public function __construct(
        protected readonly string $value,
    ) {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw InvalidUrl::fromString($value);
        }
    }
}
