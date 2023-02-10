<?php

declare(strict_types=1);

namespace Thomas\Shared\Application;

use JsonSerializable;

abstract class Command implements JsonSerializable
{
    abstract public function toArray(): array;

    public function jsonSerialize(): mixed
    {
        return array_merge([
            'command' => get_class($this),
        ], $this->toArray());
    }
}
