<?php

declare(strict_types=1);

namespace Thomas\Stations\Infrastructure;

use Thomas\Shared\Domain\CRS;
use Thomas\Stations\Domain\Stations;
use Thomas\Stations\Domain\StationService;

final class ArrayStationService implements StationService
{
    public function search(string $search): Stations
    {
        $stations = CRS::list();

        $filtered = array_filter(
            $stations,
            fn (string $key) => str_contains($key, strtoupper($search)) || str_contains(strtolower($stations[$key]), strtolower($search)),
            ARRAY_FILTER_USE_KEY
        );

        return Stations::fromArray(array_map(
            static fn (string $key, string $value): array => [
                'code' => $key,
                'name' => $value,
            ],
            array_keys($filtered),
            array_values($filtered)
        ));
    }
}
