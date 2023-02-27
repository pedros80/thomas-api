<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Domain;

final class Status
{
    public function __construct(
        private string $status
    ) {
        // @todo - validation
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
