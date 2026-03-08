<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

use Thomas\Shared\Domain\TypedCollection;
use Thomas\Stations\Domain\Station;

final class Stations extends TypedCollection
{
    protected string $type = Station::class;

    public static function fromArray(array $items): Stations
    {
        return new Stations(array_map(
            static fn (array $item): Station => Station::fromArray($item),
            $items
        ));
    }
}
