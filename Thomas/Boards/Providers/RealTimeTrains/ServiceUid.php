<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\RealTimeTrains;

use function Safe\preg_match;
use JsonSerializable;
use Thomas\Boards\Providers\RealTimeTrains\Exceptions\InvalidServiceUid;

final class ServiceUid implements JsonSerializable
{
    public function __construct(
        private string $id
    ) {
        if (!preg_match('/^[A-Z][0-9]{5}$/', $id)) {
            throw InvalidServiceUid::fromString($id);
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
