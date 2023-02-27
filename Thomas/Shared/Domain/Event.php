<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

abstract class Event implements JsonSerializable, Arrayable
{
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    abstract public function toArray(): array;

    abstract public static function deserialize(string $json): static;
}
