<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\RealTimeTrains;

use Thomas\Boards\Providers\RealTimeTrains\Exceptions\InvalidServiceUid;
use Thomas\Shared\Domain\StringValue;

use function Safe\preg_match;

final class ServiceUid extends StringValue
{
    public function __construct(
        protected readonly string $value
    ) {
        if (!preg_match('/^[A-Z][0-9]{5}$/', $value)) {
            throw InvalidServiceUid::fromString($value);
        }
    }
}
