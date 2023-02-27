<?php

declare(strict_types=1);

namespace Thomas\Users\Domain;

use Symfony\Component\Uid\Ulid;
use Thomas\Users\Domain\Exceptions\InvalidUserId;

final class UserId
{
    public function __construct(
        private string $id
    ) {
        if (!Ulid::isValid($id)) {
            throw InvalidUserId::fromString($id);
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public static function generate(): UserId
    {
        return new UserId(Ulid::generate());
    }
}
