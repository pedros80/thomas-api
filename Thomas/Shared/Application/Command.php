<?php

declare(strict_types=1);

namespace Thomas\Shared\Application;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

abstract class Command implements Arrayable, JsonSerializable
{
    abstract public function toArray(): array;

    public function jsonSerialize(): array
    {
        return array_merge([
            'command' => get_class($this),
        ], $this->toArray());
    }
}
