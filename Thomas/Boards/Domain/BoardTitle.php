<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use JsonSerializable;

final class BoardTitle implements JsonSerializable
{
    public function __construct(
        private string $boardTitle
    ) {
    }

    public function __toString(): string
    {
        return $this->boardTitle;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
