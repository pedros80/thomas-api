<?php

namespace Thomas\Stations\Infrastructure;

use Pedros80\NREphp\Params\StationCode;
use Thomas\Stations\Domain\StationService;

final class ArrayStationService implements StationService
{
    public function search(string $search): array
    {
        $stations = StationCode::list();

        $filtered = array_filter(
            $stations,
            fn (string $key) => str_contains($key, strtoupper($search)) || str_contains(strtolower($stations[$key]), strtolower($search)),
            ARRAY_FILTER_USE_KEY
        );

        return array_map(
            fn (string $key, string $value) => ['code' => $key, 'name' => $value],
            array_keys($filtered),
            array_values($filtered)
        );
    }
}
