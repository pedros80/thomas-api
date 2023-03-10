<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Domain;

final class TocCode
{
    public function __construct(
        private string $code
    ) {
        // @todo - validation
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
