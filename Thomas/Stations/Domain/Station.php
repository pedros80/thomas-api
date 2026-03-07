<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

final class Station implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly Code $code,
        public readonly Name $name
    ) {
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
