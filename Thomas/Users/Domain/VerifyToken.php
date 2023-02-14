<?php

declare(strict_types=1);

namespace Thomas\Users\Domain;

use Thomas\Users\Domain\UserId;

final class VerifyToken
{
    public function __construct(
        private string $value
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(VerifyToken $other): bool
    {
        return (string) $this === (string) $other;
    }

    public static function fromUserId(UserId $userId): VerifyToken
    {
        return new VerifyToken(sha1(time() . (string) $userId));
    }
}
