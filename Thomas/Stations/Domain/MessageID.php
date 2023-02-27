<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

final class MessageID
{
    public function __construct(
        private string $id
    ) {
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
