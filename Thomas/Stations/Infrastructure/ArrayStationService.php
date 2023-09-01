<?php

declare(strict_types=1);

namespace Thomas\Stations\Infrastructure;

use Thomas\Shared\Domain\CRS;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;
use Thomas\Stations\Domain\StationService;

final class ArrayStationService implements StationService
{
    public function search(string $search): array
    {
        $stations = CRS::list();

        $filtered = array_filter(
            $stations,
            fn (string $key) => str_contains($key, strtoupper($search)) || str_contains(strtolower($stations[$key]), strtolower($search)),
            ARRAY_FILTER_USE_KEY
        );

        return array_map(
            fn (string $key, string $value) => new Station(new Code($key), new Name($value)),
            array_keys($filtered),
            array_values($filtered)
        );
    }
}
