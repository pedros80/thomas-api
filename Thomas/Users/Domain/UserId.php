<?php

declare(strict_types=1);

namespace Thomas\Users\Domain;

use Symfony\Component\Uid\Ulid;
use Thomas\Shared\Domain\StringValue;
use Thomas\Users\Domain\Exceptions\InvalidUserId;

final class UserId extends StringValue
{
    public function __construct(
        protected readonly string $value
    ) {
        if (!Ulid::isValid($value)) {
            throw InvalidUserId::fromString($value);
        }
    }

    public static function generate(): UserId
    {
        return new UserId(Ulid::generate());
    }
}
