<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Domain;

final class Icon
{
    public function __construct(
        private string $icon
    ) {
        // @todo - validation
    }

    public function __toString(): string
    {
        return $this->icon;
    }
}
