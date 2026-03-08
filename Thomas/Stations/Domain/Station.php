<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\Name;

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

    public static function fromArray(array $station): Station
    {
        return new Station(
            new Code($station['code']),
            new Name($station['name']),
        );
    }
}
