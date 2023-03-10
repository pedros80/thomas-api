<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Domain;

final class TocName
{
    public function __construct(
        private string $name
    ) {
        // @todo - validation
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
