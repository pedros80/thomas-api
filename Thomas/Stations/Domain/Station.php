<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

use JsonSerializable;

final class Station implements JsonSerializable
{
    public function __construct(
        private Code $code,
        private Name $name
    ) {
    }

    public function toArray(): array
    {
        return [
            'code' => (string) $this->code,
            'name' => (string) $this->name,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
