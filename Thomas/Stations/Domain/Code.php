<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

final class Code
{
    public function __construct(
        private string $code
    ) {
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
